<?php namespace DoubleOptIn\ClientApi\Security;

/**
 * Class Hasher
 *
 * Hasher to hash text
 *
 * @package DoubleOptIn\ClientApi\Security
 */
class Hasher
{
	/**
	 * salt
	 *
	 * @var string
	 */
	private $salt;

	/**
	 * creates the hasher with a salt
	 *
	 * @param string $salt
	 */
	public function __construct($salt)
	{
		$this->salt = $salt;
	}

	/**
	 * hashes a text
	 *
	 * @param string $text
	 *
	 * @return string (254 chars returned)
	 */
	public function hash($text)
	{
		return $this->hash_pbkdf2('SHA256', $text, $this->salt, 1000, 127, false);
	}

	/**
	 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
	 *
	 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
	 *
	 * This implementation of PBKDF2 was originally created by https://defuse.ca
	 * With improvements by http://www.variations-of-shadow.com
	 *
	 * @see https://crackstation.net/hashing-security.htm
	 *
	 * @param string $algorithm  The hash algorithm to use. Recommended: SHA256
	 * @param string $password   The password.
	 * @param string $salt       A salt that is unique to the password.
	 * @param int $count         Iteration count. Higher is better, but slower. Recommended: At least 1000.
	 * @param int $key_length    The length of the derived key in bytes.
	 * @param bool $raw_output   If true, the key is returned in raw binary format. Hex encoded otherwise.
	 *
	 * @return string A $key_length-byte key derived from the password and salt.
	 */
	private function hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
	{
		$algorithm = strtolower($algorithm);
		if ( ! in_array($algorithm, hash_algos(), true))
			trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
		if ($count <= 0 || $key_length <= 0)
			trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

		if (function_exists("hash_pbkdf2")) {
			// The output length is in NIBBLES (4-bits) if $raw_output is false!
			if ( ! $raw_output) {
				$key_length = $key_length * 2;
			}
			return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
		}

		$hash_length = strlen(hash($algorithm, "", true));
		$block_count = ceil($key_length / $hash_length);

		$output = "";
		for ($i = 1; $i <= $block_count; $i++) {
			// $i encoded as 4 bytes, big endian.
			$last = $salt . pack("N", $i);
			// first iteration
			$last = $xorsum = hash_hmac($algorithm, $last, $password, true);
			// perform the other $count - 1 iterations
			for ($j = 1; $j < $count; $j++) {
				$xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
			}
			$output .= $xorsum;
		}

		if ($raw_output)
			return substr($output, 0, $key_length);
		else
			return bin2hex(substr($output, 0, $key_length));
	}

	/**
	 * returns a key of defined size
	 *
	 * @param string $email
	 * @param int $keySize
	 *
	 * @return string
	 */
	public function key($email, $keySize)
	{
		return substr($email . $this->salt, 0, $keySize);
	}
}