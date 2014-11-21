<?php namespace DoubleOptIn\ClientApi\Security;

use DoubleOptIn\ClientApi\Exceptions\KeyTooLongException;

/**
 * Class Crypter
 *
 * Encrypts a message
 *
 * @package DoubleOptIn\ClientApi\Security
 */
class Crypter
{
	/**
	 * crypts the given text with a key
	 *
	 * @param string $text
	 * @param string $key
	 *
	 * @throws KeyTooLongException
	 * @return string
	 */
	public function crypt($text, $key)
	{
		$td = mcrypt_module_open(MCRYPT_TWOFISH, '', MCRYPT_MODE_ECB, '');
		$this->verifyKeyLength($td, $key);

		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$encrypted = mcrypt_generic($td, $text);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		return $encrypted;
	}

	/**
	 * returns the key size available
	 *
	 * @return int
	 */
	public function getKeySize()
	{
		$td = mcrypt_module_open(MCRYPT_TWOFISH, '', MCRYPT_MODE_ECB, '');
		$keySize = mcrypt_enc_get_key_size($td);
		mcrypt_module_close($td);

		return $keySize;
	}

	/**
	 * verifies the possible key length
	 *
	 * @param resource $mcryptResource
	 * @param string $key
	 *
	 * @throws KeyTooLongException
	 */
	private function verifyKeyLength($mcryptResource, $key)
	{
		$keyLength = strlen($key);
		$maxLength = mcrypt_enc_get_key_size($mcryptResource);

		if ($keyLength > $maxLength) {
			mcrypt_module_close($mcryptResource);
			throw new KeyTooLongException('Given key exceeds the allowed size of ' . $maxLength);
		}
	}
}