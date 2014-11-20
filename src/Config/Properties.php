<?php namespace DoubleOptIn\ClientApi\Config;

/**
 * Class Properties
 *
 * Api properties
 *
 * @package DoubleOptIn\ClientApi\Config
 */
class Properties
{
	/**
	 * Url to the base api server
	 */
	const API_URL = 'https://double-opt.in';

	/**
	 * Path to the authorization endpoint
	 */
	const AUTHORIZE_PATH = '/api/access_token';

	/**
	 * base url
	 *
	 * @var string
	 */
	private static $baseUrl;

	/**
	 * setting the base url
	 *
	 * @param string $baseUrl
	 */
	public static function setBaseUrl($baseUrl)
	{
		static::$baseUrl = $baseUrl;
	}

	/**
	 * returns the base url
	 *
	 * @return string
	 */
	public static function baseUrl()
	{
		if (static::$baseUrl === null) {
			static::$baseUrl = static::API_URL;
		}

		return static::$baseUrl;
	}

	/**
	 * returns the authorization url
	 *
	 * @return string
	 */
	public static function authorizationUrl()
	{
		return static::baseUrl() . static::AUTHORIZE_PATH;
	}
}