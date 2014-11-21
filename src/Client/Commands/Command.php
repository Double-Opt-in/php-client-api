<?php namespace DoubleOptIn\ClientApi\Client\Commands;

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
	 * @return string
	 */
	public function uri()
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
	 * @return array|\Guzzle\Http\EntityBodyInterface|null|resource|string
	 */
	abstract public function body();
}