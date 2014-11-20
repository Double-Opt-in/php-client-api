<?php namespace DoubleOptIn\ClientApi\Config\Storage;

use DoubleOptIn\ClientApi\Config\ClientConfig;
use DoubleOptIn\ClientApi\Exceptions\ClientConfigurationException;

/**
 * Class FileConfigReader
 *
 * A file reader to get a configuration pre-setted
 *
 * @package DoubleOptIn\ClientApi\Config\Storage
 */
class FileConfigReader
{
	/**
	 * read configuration values from a php array file
	 *
	 * file contents has to be like this:
	 * <?php
	 * return array(
	 *   'clientId' => '...',
	 *   'clientSecret' => '...',
	 *   'permissions' => array(),  // optional
	 * );
	 * EOF;
	 *
	 * @param string $file
	 *
	 * @return ClientConfig
	 * @throws ClientConfigurationException
	 */
	public static function fromPhpFile($file)
	{
		$file = realpath($file);
		if ( ! $file)
			throw new ClientConfigurationException('Configuration file ' . $file . ' does not exists');

		$data = include $file;

		return ConfigFactory::fromArray($data);
	}
}