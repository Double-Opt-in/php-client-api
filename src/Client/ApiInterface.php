<?php namespace DoubleOptIn\ClientApi\Client;

use DoubleOptIn\ClientApi\Client\Commands\ClientCommand;
use DoubleOptIn\ClientApi\Client\Commands\Responses\CommandResponse;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;

/**
 * Interface ApiInterface
 *
 * Api interface
 *
 * @package DoubleOptIn\ClientApi\Client
 */
interface ApiInterface
{
	/**
	 * get all actions
	 *
	 * @param ClientCommand $command
	 *
	 * @return CommandResponse
	 */
	public function send(ClientCommand $command);

	/**
	 * returns CryptographyEngine
	 *
	 * @return CryptographyEngine
	 */
	public function getCryptographyEngine();
}