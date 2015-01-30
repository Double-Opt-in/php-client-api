<?php namespace DoubleOptIn\ClientApi\Client\Commands;

use DoubleOptIn\ClientApi\Client\Commands\Responses\CommandResponse;
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
	 * data
	 *
	 * @var array
	 */
	private $data;

	/**
	 * overwriting ip
	 *
	 * @var string|null
	 */
	private $ip;

	/**
	 * overwriting useragent
	 *
	 * @var string|null
	 */
	private $useragent;

	/**
	 * overwriting created_at
	 *
	 * @var string|null
	 */
	private $created_at;

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
			$body['data'] = $cryptographyEngine->encrypt(json_encode($this->data), $this->email);

		//  add overwriting data when possible
		if ( ! empty($this->ip))
			$body['ip'] = $this->ip;

		if ( ! empty($this->useragent))
			$body['useragent'] = $this->useragent;

		if ( ! empty($this->created_at))
			$body['created_at'] = $this->created_at;

		return json_encode($body);
	}

	/**
	 * creates a response from http response
	 *
	 * @param Response $response
	 * @param CryptographyEngine $cryptographyEngine
	 *
	 * @return CommandResponse
	 */
	public function response(Response $response, CryptographyEngine $cryptographyEngine)
	{
		return new CommandResponse($response);
	}

	/**
	 * sets ip
	 *
	 * @param null|string $ip
	 *
	 * @return $this
	 * @throws \InvalidArgumentException when ip validation failed
	 */
	public function setIp($ip)
	{
		if (null !== $ip) {
			if ( ! filter_var($ip, FILTER_VALIDATE_IP))
				throw new \InvalidArgumentException('Parameter ip is not a valid ip');
		}

		$this->ip = $ip;

		return $this;
	}

	/**
	 * sets useragent
	 *
	 * @param null|string $useragent
	 *
	 * @return $this
	 */
	public function setUseragent($useragent)
	{
		$this->useragent = $useragent;

		return $this;
	}

	/**
	 * sets created_at
	 *
	 * @param null|string|\DateTime $created_at
	 *
	 * @return $this
	 * @throws \InvalidArgumentException when date validation failed
	 */
	public function setCreatedAt($created_at)
	{
		if (null !== $created_at) {
			if ($created_at instanceof \DateTime)
				$created_at = $created_at->format('Y-m-d H:i:s');
			elseif ( ! strtotime($created_at))
				throw new \InvalidArgumentException('Parameter created_at is not a valid date string');
		}

		$this->created_at = $created_at;

		return $this;
	}
}