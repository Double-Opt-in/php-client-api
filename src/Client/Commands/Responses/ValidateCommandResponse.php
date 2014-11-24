<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

/**
 * Class ValidateCommandResponse
 *
 * Handles validate command response
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
class ValidateCommandResponse extends CommandResponse
{
	/**
	 * returns the error message
	 *
	 * @return string
	 */
	public function errorMessage()
	{
		if ($this->statusCode() === 404)
			return 'No entry found';

		return parent::errorMessage();
	}

	/**
	 * returns a string representation of the response, command-dependent
	 *
	 * @return string
	 */
	function toString()
	{
		return sprintf('User is in state %s', $this->decoded()->data->state);
	}
}