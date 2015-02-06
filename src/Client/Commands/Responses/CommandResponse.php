<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

use DoubleOptIn\ClientApi\Client\Commands\Responses\Models\Action;
use stdClass;

/**
 * Class CommandResponse
 *
 * Base class for command responses
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
class CommandResponse extends Response
{
	/**
	 * returns a list of all actions
	 *
	 * @return array|Action[]
	 */
	public function all()
	{
		$result = array();

		$data = $this->data();
		if ( ! is_array($data))
			$data = array($data);

		foreach ($data as $entry) {
			$result[] = $this->resolveActionFromStdClass($entry);
		}

		return $result;
	}

	/**
	 * returns the action or null
	 *
	 * @return Action|null
	 */
	public function action()
	{
		$action = $this->data();

		if ( ! $action instanceof stdClass)
			return null;

		return $this->resolveActionFromStdClass($action);
	}

	/**
	 * resolves an action from a stdClass
	 *
	 * @param \stdClass $stdClass
	 *
	 * @return Action
	 */
	protected function resolveActionFromStdClass(stdClass $stdClass)
	{
		return Action::createFromStdClass($stdClass);
	}

	/**
	 * returns decoded data
	 *
	 * @return array|\stdClass
	 */
	public function data()
	{
		return $this->decoded()->data;
	}

	/**
	 * returns decoded meta data
	 *
	 * @return array
	 */
	public function meta()
	{
		return $this->decoded()->meta;
	}
}