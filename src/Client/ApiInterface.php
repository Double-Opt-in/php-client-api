<?php namespace DoubleOptIn\ClientApi\Client;

use DoubleOptIn\ClientApi\Client\Commands\ClientCommand;

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
	 * @return \Guzzle\Http\Message\RequestInterface
	 */
	public function send(ClientCommand $command);
}