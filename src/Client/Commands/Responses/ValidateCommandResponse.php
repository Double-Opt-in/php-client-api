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
}