<?php namespace DoubleOptIn\ClientApi\Client\Commands;

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
	 * @param string $hash
	 * @param string|null $scope
	 */
	public function __construct($hash, $scope = null)
	{
		$this->hash = $hash;
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
		);

		if ( ! empty($this->scope))
			$body['scope'] = $this->scope;

		return json_encode($body);
	}
}