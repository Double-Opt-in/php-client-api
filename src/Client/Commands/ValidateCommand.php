<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Client\Commands\Responses\CommandResponse;
use DoubleOptIn\ClientApi\Client\Commands\Responses\ValidateCommandResponse;
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
	protected $method = 'POST';

	/**
	 * path to the endpoint
	 *
	 * @var string
	 */
	protected $uri = '/api/validate';

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
	 * returns the body
	 *
	 * hash: email will be hashed before requesting the server
	 * scope: optional scope will be transmitted in plain text
	 *
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return array|\Guzzle\Http\EntityBodyInterface|null|resource|string
	 */
	public function body(CryptographyEngine $cryptographyEngine)
	{
		$body = array(
			'hash' => $cryptographyEngine->hash($this->email),
		);

		if ( ! empty($this->scope))
			$body['scope'] = $this->scope;

		return json_encode($body);
	}

	/**
	 * creates a response from http response
	 *
	 * @param Response $response
	 *
	 * @return ValidateCommandResponse
	 */
	public function response(Response $response)
	{
		return new ValidateCommandResponse($response);
	}
}