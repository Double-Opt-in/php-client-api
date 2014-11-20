<?php namespace DoubleOptIn\ClientApi\Client\Commands;

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
	 * returns the body
	 *
	 * @return array|\Guzzle\Http\EntityBodyInterface|null|resource|string
	 */
	public function body()
	{
		return null;
	}
}