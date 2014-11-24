<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

/**
 * Class LogCommandResponse
 *
 * Handels the log command response
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
class LogCommandResponse extends CommandResponse
{
	/**
	 * returns a string representation of the response, command-dependent
	 *
	 * @return string
	 */
	function toString()
	{
		return sprintf('Action %s logged', $this->decoded()->data->action);
	}
}