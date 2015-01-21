<?php namespace DoubleOptIn\ClientApi\Guzzle\Plugin;

/**
 * Class OAuth2Plugin
 *
 * OAuth2Plugin with caching support for the access token
 *
 * @package DoubleOptIn\Guzzle\Plugin
 */
class OAuth2Plugin extends \CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin
{
	/**
	 * access token cache
	 *
	 * @var AccessTokenCache|null
	 */
	private $cache;

	/**
	 * sets the cache file when possible
	 *
	 * @param string $file
	 */
	public function setCache($file)
	{
		if ( ! empty($file)) {
			$this->cache = new AccessTokenCache($file);

			$this->setAccessToken($this->cache->get());
		}
	}

	/**
	 * Acquire a new access token from the server.
	 *
	 * @return array|null
	 */
	protected function acquireAccessToken()
	{
		$accessToken = parent::acquireAccessToken();

		if ($this->cache !== null)
			$this->cache->put($this->accessToken);

		return $accessToken;
	}
}