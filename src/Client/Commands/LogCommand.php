<?php namespace DoubleOptIn\ClientApi\Client\Commands;

/**
 * Class ActionsCommand
 *
 *
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
	 * hash
	 *
	 * @var string
	 */
	private $hash;

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
	 * @param string $hash
	 * @param string $action
	 * @param string|null $scope
	 */
	public function __construct($hash, $action, $scope = null)
	{
		$this->hash = $hash;
		$this->action = $action;
		$this->scope = $scope;
	}

	/**
	 * returns the body
	 *
	 * @return array|\Guzzle\Http\EntityBodyInterface|null|resource|string
	 */
	public function body()
	{
		$body = array(
			'hash' => $this->hash,
			'action' => $this->action,
		);

		if ( ! empty($this->scope))
			$body['scope'] = $this->scope;

		return json_encode($body);
	}
}