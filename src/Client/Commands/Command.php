<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Client\Commands\Responses\CommandResponse;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;
use Guzzle\Http\Message\Response;

/**
 * Class Command
 *
 * Base command implementation
 *
 * @package DoubleOptIn\ClientApi\Client\Commands
 */
abstract class Command implements ClientCommand
{
	/**
	 * http request method
	 *
	 * @var string
	 */
	protected $method;

	/**
	 * uri endpoint
	 *
	 * @var
	 */
	protected $uri;

	/**
	 * the api version this command uses
	 *
	 * @var string
	 */
	protected $apiVersion = 'v1';

	/**
	 * the format used for request
	 *
	 * @var string
	 */
	protected $format = 'json';

	/**
	 * additional headers for request
	 *
	 * @var array
	 */
	protected $headers = array();

	/**
	 * returns the method
	 *
	 * @return string
	 */
	public function method()
	{
		return $this->method;
	}

	/**
	 * returns the uri or path to the command endpoint
	 *
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return string
	 */
	public function uri(CryptographyEngine $cryptographyEngine)
	{
		return $this->uri;
	}

	/**
	 * returns the api version the command uses
	 *
	 * @return string
	 */
	public function apiVersion()
	{
		return $this->apiVersion;
	}

	/**
	 * returns the necessary format the command needs to handle the response
	 *
	 * @return string
	 */
	public function format()
	{
		return $this->format;
	}

	/**
	 * returns the additional headers
	 *
	 * @return array
	 */
	public function headers()
	{
		return $this->headers;
	}

	/**
	 * returns the body
	 *
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return array|\Guzzle\Http\EntityBodyInterface|null|resource|string
	 */
	abstract public function body(CryptographyEngine $cryptographyEngine);

	/**
	 * creates a response from http response
	 *
	 * @param Response $response
	 *
	 * @return CommandResponse
	 */
	abstract public function response(Response $response);
}