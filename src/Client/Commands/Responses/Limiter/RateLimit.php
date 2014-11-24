<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses\Limiter;

use Guzzle\Http\Message\Header\HeaderCollection;

/**
 * Class RateLimit
 *
 * Handles rate limit
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses\Limiter
 */
class RateLimit
{
	/**
	 * limit
	 *
	 * @var int
	 */
	private $limit;

	/**
	 * remaining
	 *
	 * @var int
	 */
	private $remaining;

	/**
	 * reset timestamp
	 *
	 * @var int
	 */
	private $reset;

	/**
	 * @param HeaderCollection $headers
	 */
	public function __construct(HeaderCollection $headers)
	{
		$this->limit = intval((string)$headers->get('x-ratelimit-limit'));
		$this->remaining = intval((string)$headers->get('x-ratelimit-remaining'));
		$this->reset = intval((string)$headers->get('x-ratelimit-reset'));
	}

	/**
	 * returns Limit
	 *
	 * @return int
	 */
	public function limit()
	{
		return $this->limit;
	}

	/**
	 * returns Remaining
	 *
	 * @return int
	 */
	public function remaining()
	{
		return $this->remaining;
	}

	/**
	 * returns Reset
	 *
	 * @return int
	 */
	public function reset()
	{
		return $this->reset;
	}

	/**
	 * string representation of the limiter
	 *
	 * @return string
	 */
	public function __toString()
	{
		return sprintf('%s / %s (new reset in %s seconds)', $this->remaining(), $this->limit(), $this->reset() - time());
	}
}