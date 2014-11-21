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
	 *   'clientId' => '...',
	 *   'clientSecret' => '...',
	 *   'siteToken' => '',
	 * )
	 *
	 * @param array $data
	 *
	 * @return ClientConfig
	 * @throws ClientConfigurationException
	 */
	public static function fromArray(array $data)
	{
		if ( ! array_key_exists('clientId', $data))
			throw new ClientConfigurationException('Configuration file has no clientId set');
		if ( ! array_key_exists('clientSecret', $data))
			throw new ClientConfigurationException('Configuration file has no clientSecret set');
		if ( ! array_key_exists('siteToken', $data))
			throw new ClientConfigurationException('Configuration file has no siteToken set');

		$baseUrl = ( ! array_key_exists('api', $data))
			? null
			: $data['api'];

		return new ClientConfig($data['clientId'], $data['clientSecret'], $data['siteToken'], $baseUrl);
	}
}