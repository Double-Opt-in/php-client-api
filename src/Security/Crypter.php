<?php namespace DoubleOptIn\ClientApi\Security;

use DoubleOptIn\ClientApi\Security\SlowAES\AES;
use DoubleOptIn\ClientApi\Security\SlowAES\cryptoHelpers;
use Exception;

/**
 * Class Crypter
 *
 * Encrypts and decrypts a message, using SlowAES
 *
 * @package DoubleOptIn\ClientApi\Security
 */
class Crypter
{
	const IDENTIFIER = 'slowaes';
	const SEPARATOR_ALGORITHM = ':';
	const SEPARATOR_CRYPTO_PARTS = ' ';

	/**
	 * encrypts the given plain text with a key
	 *
	 * @param string $plaintext
	 * @param string $key
	 *
	 * @return string
	 */
	public function encrypt($plaintext, $key)
	{
		// Set up encryption parameters.
		$inputData = cryptoHelpers::convertStringToByteArray($plaintext);
		$keyAsNumbers = cryptoHelpers::toNumbers(bin2hex($key));
		$keyLength = count($keyAsNumbers);
		$iv = cryptoHelpers::generateSharedKey(16);

		$encrypted = AES::encrypt(
			$inputData,
			AES::modeOfOperation_CBC,
			$keyAsNumbers,
			$keyLength,
			$iv
		);

		$retVal = $encrypted['originalsize'] . self::SEPARATOR_CRYPTO_PARTS
			. cryptoHelpers::toHex($iv) . self::SEPARATOR_CRYPTO_PARTS
			. cryptoHelpers::toHex($encrypted['cipher']);

		return self::IDENTIFIER . self::SEPARATOR_ALGORITHM . $retVal;
	}

	/**
	 * decrypts a message
	 *
	 * @param string $encrypted
	 * @param string $key
	 *
	 * @return string
	 * @throws Exception
	 */
	public function decrypt($encrypted, $key)
	{
		list($identifier, $input) = explode(self::SEPARATOR_ALGORITHM, $encrypted, 2);

		if ($identifier !== self::IDENTIFIER)
			throw new Exception('Encryption can not be decrypted. Unsupported identifier: ' . $identifier);

		// Split the input into its parts
		$cipherSplit = explode(self::SEPARATOR_CRYPTO_PARTS, $input);
		$originalSize = intval($cipherSplit[0]);
		$iv = cryptoHelpers::toNumbers($cipherSplit[1]);
		$cipherText = $cipherSplit[2];

		// Set up encryption parameters
		$cipherIn = cryptoHelpers::toNumbers($cipherText);
		$keyAsNumbers = cryptoHelpers::toNumbers(bin2hex($key));
		$keyLength = count($keyAsNumbers);

		$decrypted = AES::decrypt(
			$cipherIn,
			$originalSize,
			AES::modeOfOperation_CBC,
			$keyAsNumbers,
			$keyLength,
			$iv
		);

		// Byte-array to text.
		$hexDecrypted = cryptoHelpers::toHex($decrypted);
		$retVal = pack("H*", $hexDecrypted);

		return $retVal;
	}
}