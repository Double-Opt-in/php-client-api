<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

use DoubleOptIn\ClientApi\Client\Commands\Responses\Models\Action;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;
use stdClass;

/**
 * Class DecryptedCommandResponse
 *
 * Encrypted data will be automatically decrypted
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
final class DecryptedCommandResponse extends CommandResponse
{
	/**
	 * cryptography engine
	 *
	 * @var CryptographyEngine
	 */
	private $cryptographyEngine;

	/**
	 * email to decrypt
	 *
	 * @var string
	 */
	private $email;

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
		$this->cryptographyEngine = $cryptographyEngine;
		$this->email = $email;
	}

	/**
	 * resolves an action from a stdClass
	 *
	 * @param \stdClass $stdClass
	 *
	 * @return Action
	 */
	protected function resolveActionFromStdClass(stdClass $stdClass)
	{
		if (isset($stdClass->data))
			$stdClass->data = $this->cryptographyEngine->decrypt($stdClass->data, $this->email);

		return Action::createFromStdClass($stdClass);
	}
}