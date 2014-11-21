<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Security\CryptographyEngine;
use Guzzle\Http\EntityBodyInterface;

/**
 * Interface ClientCommand
 *
 * Interface for a client command to send to api server
 *
 * @package DoubleOptIn\ClientApi\Client\Commands
 */
interface ClientCommand
{
	/**
	 * returns the method
	 *
	 * @return string
	 */
	public function method();

	/**
	 * returns the uri or path to the command endpoint
	 *
	 * @return string
	 */
	public function uri();

	/**
	 * returns the api version the command uses
	 *
	 * @return string
	 */
	public function apiVersion();

	/**
	 * returns the necessary format the command needs to handle the response
	 *
	 * @return string
	 */
	public function format();

	/**
	 * returns additional headers for the command request
	 *
	 * @return array
	 */
	public function headers();

	/**
	 * returns the body to send
	 *
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return string|resource|array|EntityBodyInterface|null
	 */
	public function body(CryptographyEngine $cryptographyEngine);
}