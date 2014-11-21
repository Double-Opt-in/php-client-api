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
		$this->email = $email;
		$this->action = $action;
		$this->scope = $scope;
	}

	/**
	 * returns query parameter
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

		if ( ! empty($this->action))
			$params['action'] = $this->action;

		if ( ! empty($this->scope))
			$params['scope'] = $this->scope;

		$query = http_build_query($params);

		return $uri . (empty($query) ? '' : '?' . $query);
	}

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