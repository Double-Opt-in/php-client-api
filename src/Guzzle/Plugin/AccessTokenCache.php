<?php namespace DoubleOptIn\ClientApi\Guzzle\Plugin;

/**
 * Class AccessTokenCache
 *
 * Access token cache
 *
 * @package DoubleOptIn\Guzzle\Plugin
 */
class AccessTokenCache
{
	/**
	 * file to cache the access token in
	 *
	 * @var string
	 */
	private $file;

	/**
	 * @param string $file
	 */
	public function __construct($file)
	{
		$this->file = $file;
	}

	/**
	 * returns the cached access token
	 *
	 * @return array
	 */
	public function get()
	{
		if ( ! file_exists($this->file))
			return array();

		$data = unserialize(base64_decode(file_get_contents($this->file)));

		return $data ?: array();
	}

	/**
	 * store the access token
	 *
	 * @param array $accessToken
	 *
	 * @return bool
	 */
	public function put($accessToken)
	{
		if ($accessToken === null)
			return unlink($this->file);

		file_put_contents($this->file, base64_encode(serialize($accessToken)));

		return file_exists($this->file);
	}
}