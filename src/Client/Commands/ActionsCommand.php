<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Security\CryptographyEngine;

/**
 * Class ActionsCommand
 *
 * Actions command
 *
 * @package DoubleOptIn\ClientApi\Client\Commands
 */
class ActionsCommand extends Command
{
	/**
	 * http request method
	 *
	 * @var string
	 */
	protected $method = 'GET';

	/**
	 * path to the endpoint
	 *
	 * @var string
	 */
	protected $uri = '/api/actions';

	/**
	 * returns the body
	 *
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return array|\Guzzle\Http\EntityBodyInterface|null|resource|string
	 */
	public function body(CryptographyEngine $cryptographyEngine)
	{
		return null;
	}
}