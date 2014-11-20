<?php namespace DoubleOptIn\ClientApi\Config\Storage;

use DoubleOptIn\ClientApi\Config\ClientConfig;
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
	 *   'clientId' => '...',
	 *   'clientSecret' => '...',
	 *   'permissions' => array(),  // optional
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

		$clientPermissions = array_key_exists('permissions', $data) ? $data['permissions'] : array();

		return new ClientConfig($data['clientId'], $data['clientSecret'], $clientPermissions);
	}
}