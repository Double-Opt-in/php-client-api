<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses\Models;

use DateTime;
use stdClass;

/**
 * Class Action
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses\Models
 */
class Action
{
	/**
	 * hash
	 *
	 * @var string
	 */
	private $hash;

	/**
	 * scope
	 *
	 * @var string
	 */
	private $scope;

	/**
	 * action
	 *
	 * @var string
	 */
	private $action;

	/**
	 * data
	 *
	 * @var string
	 */
	private $data;

	/**
	 * state
	 *
	 * @var string
	 */
	private $state;

	/**
	 * ip
	 *
	 * @var string
	 */
	private $ip;

	/**
	 * user agent
	 *
	 * @var string
	 */
	private $useragent;

	/**
	 * created at
	 *
	 * @var DateTime
	 */
	private $createdAt;

	/**
	 * @param string $hash
	 * @param string $scope
	 * @param string $action
	 * @param string $data
	 * @param string $state
	 * @param string $ip
	 * @param string $useragent
	 * @param string|DateTime $createdAt
	 */
	public function __construct($hash, $scope, $action, $data, $state, $ip, $useragent, $createdAt)
	{
		$this->hash = $hash;
		$this->scope = $scope;
		$this->action = $action;
		$this->state = $state;
		$this->data = $data;
		$this->ip = $ip;
		$this->useragent = $useragent;

		$this->setCreatedAt($createdAt);
	}

	/**
	 * creates from a stdClass
	 *
	 * @param stdClass $class
	 *
	 * @return \DoubleOptIn\ClientApi\Client\Commands\Responses\Models\Action
	 */
	public static function createFromStdClass(stdClass $class)
	{
		$hash = isset($class->hash) ? $class->hash : null;
		$scope = isset($class->scope) ? $class->scope : null;
		$action = isset($class->action) ? $class->action : null;
		$data = isset($class->data) ? $class->data : null;
		$state = isset($class->state) ? $class->state : null;
		$ip = isset($class->ip) ? $class->ip : null;
		$useragent = isset($class->useragent) ? $class->useragent : null;
		$createdAt = isset($class->created_at) ? $class->created_at : null;

		return new Action($hash, $scope, $action, $data, $state, $ip, $useragent, $createdAt);
	}

	/**
	 * returns Hash
	 *
	 * @return string
	 */
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * returns Scope
	 *
	 * @return string
	 */
	public function getScope()
	{
		return $this->scope;
	}

	/**
	 * returns Action
	 *
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * returns Data
	 *
	 * @return string
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * returns Ip
	 *
	 * @return string
	 */
	public function getIp()
	{
		return $this->ip;
	}

	/**
	 * returns Useragent
	 *
	 * @return string
	 */
	public function getUseragent()
	{
		return $this->useragent;
	}

	/**
	 * returns CreatedAt
	 *
	 * @return DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * sets createdAt
	 *
	 * @param string|DateTime $createdAt
	 *
	 * @return $this
	 */
	public function setCreatedAt($createdAt)
	{
		if ( ! $createdAt instanceof DateTime)
			$createdAt = new DateTime($createdAt);

		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * returns State
	 *
	 * @return string
	 */
	public function getState()
	{
		return $this->state;
	}
}