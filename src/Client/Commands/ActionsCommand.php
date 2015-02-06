<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Client\Commands\Responses\DecryptedCommandResponse;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;
use Guzzle\Http\Message\Response;

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
	protected $uri = '/actions';

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
	 * @param string $email
	 * @param string|null $action
	 * @param string|null $scope
	 */
	public function __construct($email, $action = null, $scope = null)
	{
		$this->email = strtolower($email);
		$this->action = $action;
		$this->scope = $scope;
	}

	/**
	 * returns query parameter
	 *
	 * hash: email will be hashed before requesting the server
	 * action: optional action will be transmitted in plain text
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

		if (null !== $this->action)
			$params['action'] = $this->action;

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
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return DecryptedCommandResponse
	 */
	public function response(Response $response, CryptographyEngine $cryptographyEngine)
	{
		$decryptedResponse = new DecryptedCommandResponse($response);

		$decryptedResponse->assignCryptographyEngine($cryptographyEngine, $this->email);

		return $decryptedResponse;
	}
}