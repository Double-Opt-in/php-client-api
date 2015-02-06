<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

use DoubleOptIn\ClientApi\Client\Commands\Responses\Models\Status;
use stdClass;

/**
 * Class StatusResponse
 *
 *
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
class StatusResponse extends Response
{
	/**
	 * status model
	 *
	 * @var Status
	 */
	private $status;

	/**
	 * returns the status model
	 *
	 * @return Status|null
	 */
	public function status()
	{
		if ($this->status === null) {
			$stdClass = $this->decoded();
			if ( ! $stdClass instanceof stdClass)
				return null;

			$this->status = $this->resolveStatusFromStdClass($stdClass);
		}

		return $this->status;
	}

	/**
	 * resolves the status object
	 *
	 * @param stdClass $stdClass
	 *
	 * @return Status
	 */
	private function resolveStatusFromStdClass(stdClass $stdClass)
	{
		return Status::createFromStdClass($stdClass);
	}
}