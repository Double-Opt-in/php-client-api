<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

/**
 * Class ActionsCommandResponse
 *
 * Handles the actions command response
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
class ActionsCommandResponse extends CommandResponse
{
	/**
	 * returns a string representation of the response, command-dependent
	 *
	 * @return string
	 */
	public function toString()
	{
		$meta = $this->decoded()->meta;

		$message =
			  'created at               | action (scope)          | data' . PHP_EOL
			. '-------------------------+-------------------------+-------------------------';

		foreach ($this->all() as $entry) {
			$scope = $entry->getScope();
			$scope = empty($scope) ? '' : ' (' . $$scope . ')';
			$message .= PHP_EOL . sprintf('%s | %s%s', $entry->getCreatedAt()->format('Y-m-d H:i:s'), $entry->getAction(), $scope);
		}

		$message .= PHP_EOL . PHP_EOL . sprintf('%s of %s | page %s of %s | %s entries per page',
				$meta->pagination->count,
				$meta->pagination->total,
				$meta->pagination->current_page,
				$meta->pagination->total_pages,
				$meta->pagination->per_page
			);


		return $message;
	}
}