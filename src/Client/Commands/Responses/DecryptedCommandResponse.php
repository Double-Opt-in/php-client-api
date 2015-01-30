<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

use DoubleOptIn\ClientApi\Security\CryptographyEngine;

/**
 * Class DecryptedCommandResponse
 *
 * Encrypted data will be automatically decrypted
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
class DecryptedCommandResponse extends CommandResponse
{
	/**
	 * assigns the cryptography engine
	 *
	 * @param \DoubleOptIn\ClientApi\Security\CryptographyEngine $cryptographyEngine
	 * @param string $email
	 *
	 * @return void
	 */
	public function assignCryptographyEngine(CryptographyEngine $cryptographyEngine, $email)
	{
		$this->decoded()->data = $cryptographyEngine->decrypt($this->decoded()->data, $email);
	}
}