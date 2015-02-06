<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses\Models;

use stdClass;

/**
 * Class Status
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses\Models
 */
class Status
{
	/**
	 * site name
	 *
	 * @var string
	 */
	private $site;

	/**
	 * site type
	 *
	 * @var string
	 */
	private $type;

	/**
	 * storage time in seconds
	 *
	 * @var int
	 */
	private $storage_time;

	/**
	 * credits left
	 *
	 * @var int
	 */
	private $credits;

	/**
	 * soft quota limit
	 *
	 * @var int
	 */
	private $soft_quota;

	/**
	 * hard quota limit
	 *
	 * @var int
	 */
	private $hard_quota;

	/**
	 * daily credits usage (approximation)
	 *
	 * @var int
	 */
	private $daily_credits_usage;

	/**
	 * unique mail hashes or identities
	 *
	 * @var int
	 */
	private $unique_hashes;

	/**
	 * @param string $site
	 * @param string $type
	 * @param int $storage_time
	 * @param int $credits
	 * @param int $soft_quota
	 * @param int $hard_quota
	 * @param int $daily_credits_usage
	 * @param int $unique_hashes
	 */
	public function __construct($site, $type, $storage_time, $credits, $soft_quota, $hard_quota, $daily_credits_usage, $unique_hashes)
	{
		$this->site = $site;
		$this->type = $type;
		$this->storage_time = $storage_time;
		$this->credits = $credits;
		$this->soft_quota = $soft_quota;
		$this->hard_quota = $hard_quota;
		$this->daily_credits_usage = $daily_credits_usage;
		$this->unique_hashes = $unique_hashes;
	}

	/**
	 * creates from a stdClass
	 *
	 * @param stdClass $class
	 *
	 * @return Status
	 */
	public static function createFromStdClass(stdClass $class)
	{
		$site = isset($class->site) ? $class->site : null;
		$type = isset($class->type) ? $class->type : null;
		$storage_time = isset($class->storage_time) ? $class->storage_time : 0;
		$credits = isset($class->credits) ? $class->credits : 0;
		$soft_quota = isset($class->soft_quota) ? $class->soft_quota : 0;
		$hard_quota = isset($class->hard_quota) ? $class->hard_quota : 0;
		$daily_credits_usage = isset($class->daily_credits_usage) ? $class->daily_credits_usage : 0;
		$unique_hashes = isset($class->unique_hashes) ? $class->unique_hashes : 0;

		return new Status($site, $type, $storage_time, $credits, $soft_quota, $hard_quota, $daily_credits_usage, $unique_hashes);
	}

	/**
	 * returns Site
	 *
	 * @return string
	 */
	public function getSite()
	{
		return $this->site;
	}

	/**
	 * returns Type
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * returns StorageTime
	 *
	 * @return int
	 */
	public function getStorageTime()
	{
		return $this->storage_time;
	}

	/**
	 * returns Credits
	 *
	 * @return int
	 */
	public function getCredits()
	{
		return $this->credits;
	}

	/**
	 * returns SoftQuota
	 *
	 * @return int
	 */
	public function getSoftQuota()
	{
		return $this->soft_quota;
	}

	/**
	 * returns HardQuota
	 *
	 * @return int
	 */
	public function getHardQuota()
	{
		return $this->hard_quota;
	}

	/**
	 * returns DailyCreditsUsage
	 *
	 * @return int
	 */
	public function getDailyCreditsUsage()
	{
		return $this->daily_credits_usage;
	}

	/**
	 * returns UniqueHashes
	 *
	 * @return int
	 */
	public function getUniqueHashes()
	{
		return $this->unique_hashes;
	}

	/**
	 * returns status as array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'site' => $this->site,
			'type' => $this->type,
			'storage_time' => $this->storage_time,
			'credits' => $this->credits,
			'soft_quota' => $this->soft_quota,
			'hard_quota' => $this->hard_quota,
			'daily_credits_usage' => $this->daily_credits_usage,
			'unique_hashes' => $this->unique_hashes,
		);
	}
}