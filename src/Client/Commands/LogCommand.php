<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Client\Commands\Responses\CommandResponse;
use DoubleOptIn\ClientApi\Client\Commands\Responses\LogCommandResponse;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;
use Guzzle\Http\Message\Response;

/**
 * Class LogCommand
 *
 * Logs an action for an email
 *
 * @package DoubleOptIn\ClientApi\Client\Commands
 */
class LogCommand extends Command
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
	protected $uri = '/api/actions';

	/**
	 * email
	 *
	 * @var string
	 */
	private $email;

	/**
	 * action
	 *
	 * @var string
	 */
	private $action;

	/**
	 * scope
	 *
	 * @var string
	 */
	private $scope;

	/**
	 * data
	 *
	 * @var array
	 */
	private $data;

	/**
	 * @param string $email
	 * @param string $action
	 * @param string|null $scope
	 */
	public function __construct($email, $action, $scope = null)
	{
		$this->email = $email;
		$this->action = $action;
		$this->scope = $scope;
	}

	/**
	 * setting data to add for the logging action
	 *
	 * we suggest setting an array
	 *
	 * @param array|mixed $data
	 * @param null $key
	 *
	 * @return $this
	 */
	public function setData($data, $key = null)
	{
		if (is_array($data) && $key === null) {
			$this->data = $data;
			return $this;
		}

		if ($key === null)
			$key = 'data';

		$this->data[$key] = $data;

		return $this;
	}

	/**
	 * returns the body
	 *
	 * hash: email will be hashed before requesting the server
	 * action: action will be transmitted in plain text
	 * scope: optional scope will be transmitted in plain text
	 * data: optional data will be encrypted before requesting the server
	 *
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return array|\Guzzle\Http\EntityBodyInterface|null|resource|string
	 */
	public function body(CryptographyEngine $cryptographyEngine)
	{
		$body = array(
			'hash' => $cryptographyEngine->hash($this->email),
			'action' => $this->action,
		);

		if ( ! empty($this->scope))
			$body['scope'] = $this->scope;

		if ( ! empty($this->data))
			$body['data'] = base64_encode(
				$cryptographyEngine->encrypt(json_encode($this->data), $this->email)
			);

		return json_encode($body);
	}

	/**
	 * creates a response from http response
	 *
	 * @param Response $response
	 *
	 * @return LogCommandResponse
	 */
	public function response(Response $response)
	{
		return new LogCommandResponse($response);
	}
}