<?php namespace DoubleOptIn\ClientApi\Client;

use CommerceGuys\Guzzle\Plugin\Oauth2\GrantType\ClientCredentials;
use DoubleOptIn\ClientApi\Client\Commands\ClientCommand;
use DoubleOptIn\ClientApi\Config\ClientConfig;
use DoubleOptIn\ClientApi\Config\Properties;
use DoubleOptIn\ClientApi\Guzzle\Plugin\OAuth2Plugin;
use DoubleOptIn\ClientApi\Security\CryptographyEngine;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\ServerErrorResponseException;

/**
 * Class Api
 *
 * Api is the controller to handle all commands from user and fetch results from double-opt.in
 *
 * @package DoubleOptIn\ClientApi\Client
 */
class Api implements ApiInterface
{
	/**
	 * current client api version
	 */
	const VERSION = '0.0.1';

	/**
	 * client configuration
	 *
	 * @var ClientConfig
	 */
	private $config;

	/**
	 * http client
	 *
	 * @var ClientInterface
	 */
	private $client;

	/**
	 * the cryptography engine to use
	 *
	 * @var CryptographyEngine
	 */
	private $cryptographyEngine;

	/**
	 * @param ClientConfig $config
	 * @param ClientInterface|null $client
	 */
	public function __construct(ClientConfig $config, ClientInterface $client = null)
	{
		$this->config = $config;
		$this->client = $this->resolveClient($client);

		$this->setupOAuth2Plugin();

		$this->cryptographyEngine = new CryptographyEngine($config->siteToken());
	}

	/**
	 * resolves a http client
	 *
	 * @param ClientInterface|null $client
	 *
	 * @return ClientInterface|Client
	 */
	private function resolveClient($client)
	{
		$client = ! empty($client)
			? $client
			: new Client();

		$client->setBaseUrl(Properties::baseUrl())
			->setUserAgent('Double Opt-in php-api/' . self::VERSION);

		return $client;
	}

	/**
	 * setting up the oauth2 plugin for authorizing the requests
	 */
	private function setupOAuth2Plugin()
	{
		$oauth2AuthorizationClient = $this->resolveClient(null);
		$oauth2AuthorizationClient->setBaseUrl(Properties::authorizationUrl());

		$clientCredentials = new ClientCredentials($oauth2AuthorizationClient, $this->config->toArray());
		$oauth2Plugin = new OAuth2Plugin($clientCredentials);
		$oauth2Plugin->setCache($this->config->getAccessTokenCacheFile());

		$this->client->addSubscriber($oauth2Plugin);
	}

	/**
	 * get all actions
	 *
	 * @param ClientCommand $command
	 *
	 * @return \Guzzle\Http\Message\RequestInterface
	 */
	public function send(ClientCommand $command)
	{
		$request = $this->client->createRequest(
			$command->method(),
			$command->uri(),
			$this->headers($command->apiVersion(), $command->format(), $command->headers()),
			$command->body($this->cryptographyEngine)
		);

		try {
			$response = $request->send();
		} catch (ClientErrorResponseException $exception) {
			echo 'Error occurred for last request...';
			echo PHP_EOL;
			echo PHP_EOL;
			echo '--- REQUEST ---';
			echo PHP_EOL;
			echo $exception->getRequest()->getRawHeaders();
			echo PHP_EOL;
			echo PHP_EOL;
			echo '--- RESPONSE ---';
			echo PHP_EOL;
			echo $exception->getResponse()->getRawHeaders();
			echo $exception->getResponse()->getBody();
			echo PHP_EOL;

			return null;
		} catch (ServerErrorResponseException $exception) {
			echo 'Error occurred for last request...';
			echo PHP_EOL;
			echo PHP_EOL;
			echo '--- REQUEST ---';
			echo PHP_EOL;
			echo $exception->getRequest()->getRawHeaders();
			echo PHP_EOL;
			echo PHP_EOL;
			echo $command->body($this->cryptographyEngine);
			echo PHP_EOL;
			echo PHP_EOL;
			echo '--- RESPONSE ---';
			echo PHP_EOL;
			echo $exception->getResponse()->getRawHeaders();
			echo $exception->getResponse()->getBody();
			echo PHP_EOL;

			return null;
		}

		/** @var \Guzzle\Http\Message\Header $contentType */
		$contentType = (string)$response->getHeader('content-type');
		if ($contentType === 'application/json')
		{
			return json_decode($response->getBody(true));
		}

		return $response->getBody(true);
	}

	/**
	 * returns version based headers
	 *
	 * @param string $apiVersion
	 * @param string $format
	 * @param array $additionalHeaders
	 *
	 * @return array
	 */
	private function headers($apiVersion, $format, array $additionalHeaders = array())
	{
		return array_merge(array(
			'Accept' => 'application/vnd.double-opt-in.' . $apiVersion . '+' . $format,
			'Content-Type' => 'application/' . $format,
		), $additionalHeaders);
	}
}