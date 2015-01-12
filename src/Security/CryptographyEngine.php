<?php namespace DoubleOptIn\ClientApi\Security;

use Exception;

/**
 * Class CryptoEngine
 *
 * Cryptography engine for handling the hashing and crypting within the api client
 *
 * @package DoubleOptIn\ClientApi\Security
 */
class CryptographyEngine
{
	/**
	 * hasher instance
	 *
	 * @var Hasher
	 */
	private $hasher;

	/**
	 * @param string $siteToken
	 */
	public function __construct($siteToken)
	{
		$this->hasher = new Hasher($siteToken);
		$this->crypter = new Crypter();
	}

	/**
	 * returns the hashed text
	 *
	 * @param string $email
	 *
	 * @return string
	 */
	public function hash($email)
	{
		return $this->hasher->hash($email);
	}

	/**
	 * encrypts a given string with given hash
	 *
	 * @param string $text
	 * @param string $email
	 *
	 * @return string
	 */
	public function encrypt($text, $email)
	{
		$key = $this->hasher->key($email);

		return $this->crypter->encrypt($text, $key);
	}

	/**
	 * decrypts a given encrypted message container
	 * e.g.: "slowaes:11 41bc1eacf6ce685c8eb7649da0d080995223165277af8bc068c90f7eb831d5ae
	 * 97be775203f003fef3c808e4b588c69b"
	 *
	 * @param string $text
	 * @param string $email
	 *
	 * @return string
	 * @throws Exception
	 */
	public function decrypt($text, $email)
	{
		$key = $this->hasher->key($email);

		return $this->crypter->decrypt($text, $key);
	}
}