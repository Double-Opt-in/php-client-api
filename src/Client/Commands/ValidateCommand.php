<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Client\Commands\Responses\CommandResponse;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;
use Guzzle\Http\Message\Response;

/**
 * Class ValidateCommand
 *
 * Validate command
 *
 * @package DoubleOptIn\ClientApi\Client\Commands
 */
class ValidateCommand extends Command
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
	protected $uri = '/validate';

	/**
	 * email
	 *
	 * @var string
	 */
	private $email;

	/**
	 * scope
	 *
	 * @var string
	 */
	private $scope;

	/**
	 * @param string $email
	 * @param string|null $scope
	 */
	public function __construct($email, $scope = null)
	{
		$this->email = $email;
		$this->scope = $scope;
	}

	/**
	 * returns query parameter
	 *
	 * hash: email will be hashed before requesting the server
	 * scope: optional scope will be transmitted in plain text
	 *
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return string
	 */
	public function uri(CryptographyEngine $cryptographyEngine)
	{
		$uri = parent::uri($cryptographyEngine);

		$params = array(
			'hash' => $cryptographyEngine->hash($this->email),
		);

		if (null !== $this->scope)
			$params['scope'] = $this->scope;

		$query = http_build_query($params);

		return $uri . (empty($query) ? '' : '?' . $query);
	}

	/**
	 * returns an empty body
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
	 *
	 * @return CommandResponse
	 */
	public function response(Response $response)
	{
		return new CommandResponse($response);
	}
}