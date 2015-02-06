<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Client\Commands\Responses\StatusResponse;
use Guzzle\Http\Message\Response;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;

/**
 * Class StatusCommand
 *
 * Status command for setting up a status request
 *
 * @package DoubleOptIn\ClientApi\Client\Commands
 */
class StatusCommand extends Command
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
	protected $uri = '/status';

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

	/**
	 * creates a response from http response
	 *
	 * @param Response $response
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return StatusResponse
	 */
	public function response(Response $response, CryptographyEngine $cryptographyEngine)
	{
		return new StatusResponse($response);
	}
}