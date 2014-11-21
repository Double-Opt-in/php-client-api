<?php namespace DoubleOptIn\ClientApi\Security;

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
	 * crypts a given string with given hash
	 *
	 * @param string $text
	 * @param string $email
	 *
	 * @return string
	 */
	public function encrypt($text, $email)
	{
		return $this->crypter->crypt($text, $this->hash($email));
	}
}