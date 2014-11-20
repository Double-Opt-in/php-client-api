<?php namespace DoubleOptIn\ClientApi\Config;

/**
 * Class ClientConfig
 *
 * Client configuration for retrieving an access token
 *
 * @package DoubleOptIn\ClientApi\Config
 */
class ClientConfig
{
	/**
	 * client id
	 *
	 * @var string
	 */
	private $clientId;

	/**
	 * client secret
	 *
	 * @var string
	 */
	private $clientSecret;

	/**
	 * cache file for storing access tokens
	 *
	 * @var string
	 */
	private $accessTokenCacheFile = '/tmp/access_token';

	/**
	 * site token
	 *
	 * @var string
	 */
	private $siteToken;

	/**
	 * @param string $clientId
	 * @param string $clientSecret
	 * @param string $siteToken
	 * @param string|null $baseUrl
	 */
	public function __construct($clientId, $clientSecret, $siteToken, $baseUrl = null)
	{
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->siteToken = $siteToken;

		if (null !== $baseUrl)
			Properties::setBaseUrl($baseUrl);
	}

	/**
	 * returns client id
	 *
	 * @return string
	 */
	public function clientId()
	{
		return $this->clientId;
	}

	/**
	 * returns client secret
	 *
	 * @return string
	 */
	public function clientSecret()
	{
		return $this->clientSecret;
	}

	/**
	 * returns SiteToken
	 *
	 * @return string
	 */
	public function siteToken()
	{
		return $this->siteToken;
	}

	/**
	 * returns api client config as array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'client_id' => $this->clientId(),
			'client_secret' => $this->clientSecret(),
		);
	}

	/**
	 * returns AccessTokenCacheFile
	 *
	 * @return string
	 */
	public function getAccessTokenCacheFile()
	{
		return $this->accessTokenCacheFile;
	}

	/**
	 * sets accessTokenCacheFile
	 *
	 * @param string $accessTokenCacheFile
	 *
	 * @return $this
	 */
	public function setAccessTokenCacheFile($accessTokenCacheFile)
	{
		$this->accessTokenCacheFile = $accessTokenCacheFile;

		return $this;
	}
}