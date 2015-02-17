<?php namespace DoubleOptIn\ClientApi\Config;

use DoubleOptIn\ClientApi\Exceptions\ClientConfigurationException;

/**
 * Class ConfigFactory
 *
 * Config factory creates a ClientConfig instance
 *
 * @package DoubleOptIn\ClientApi\Config\Storage
 */
class ConfigFactory
{
	/**
	 * creates a configuration from array
	 *
	 * array(
	 *   'api' => '',  // optional
	 *   'client_id' => '...',
	 *   'client_secret' => '...',
	 *   'site_token' => '',
	 *   'cache_file' => '..',
	 * )
	 *
	 * @param array $data
	 *
	 * @return ClientConfig
	 * @throws ClientConfigurationException
	 */
	public static function fromArray(array $data)
	{
		if ( ! array_key_exists('client_id', $data))
			throw new ClientConfigurationException('Configuration file has no client_id set');
		if ( ! array_key_exists('client_secret', $data))
			throw new ClientConfigurationException('Configuration file has no client_secret set');
		if ( ! array_key_exists('site_token', $data))
			throw new ClientConfigurationException('Configuration file has no site_token set');

		$baseUrl = ( ! array_key_exists('api', $data))
			? null
			: $data['api'];

		$httpClientConfig = ( ! array_key_exists('http_client', $data))
			? array()
			: $data['http_client'];

		$clientConfig = new ClientConfig($data['client_id'], $data['client_secret'], $data['site_token'], $baseUrl, $httpClientConfig);

		if (array_key_exists('cache_file', $data))
			$clientConfig->setAccessTokenCacheFile($data['cache_file']);

		return $clientConfig;
	}

	/**
	 * creates a configuration from a php file returning an array
	 *
	 * @param string $filename
	 *
	 * @return ClientConfig
	 * @throws ClientConfigurationException
	 */
	public static function fromFile($filename)
	{
		$filename = realpath($filename);
		if ($filename === false)
			throw new ClientConfigurationException('Configuration file ' . $filename . ' does not exists');

		return static::fromArray(include $filename);
	}
}