<?php namespace DoubleOptIn\ClientApi\Client\Commands\Responses;

use DoubleOptIn\ClientApi\Client\Commands\Responses\Limiter\RateLimit;
use Guzzle\Http\Message\Response as HttpResponse;
use stdClass;

/**
 * Class Response
 *
 * abstract response
 *
 * @package DoubleOptIn\ClientApi\Client\Commands\Responses
 */
abstract class Response
{
	/**
	 * original response
	 *
	 * @var Response
	 */
	protected $response;

	/**
	 * limiter
	 *
	 * @var RateLimit
	 */
	private $limiter;

	/**
	 * @param HttpResponse $response
	 */
	public function __construct(HttpResponse $response)
	{
		$this->response = $response;

		$this->limiter = new RateLimit($response->getHeaders());
	}

	/**
	 * returns limiter
	 *
	 * @return RateLimit
	 */
	public function limiter()
	{
		return $this->limiter;
	}

	/**
	 * command failed?
	 *
	 * @return bool
	 */
	public function fails()
	{
		return $this->response->getStatusCode() >= 300;
	}

	/**
	 * returns status code
	 *
	 * @return int
	 */
	public function statusCode()
	{
		return $this->response->getStatusCode();
	}

	/**
	 * return json decoded \stdClass
	 *
	 * @var stdClass
	 */
	private $json;

	/**
	 * returns decoded object
	 *
	 * @return null|stdClass
	 */
	protected function decoded()
	{
		if ($this->json === null) {
			/** @var \Guzzle\Http\Message\Header $contentType */
			$contentType = (string)$this->response->getHeader('content-type');
			if ($contentType === 'application/json')
				$this->json = json_decode($this->response->getBody(true));
		}

		return $this->json;
	}

	/**
	 * returns the error message
	 *
	 * @return string
	 */
	public function errorMessage()
	{
		if ($this->decoded() === null) {
			throw new \RuntimeException('No result from server.');
		}

		$decoded = $this->decoded();
		if (isset($decoded->error))
			return sprintf('%s (%s)', $decoded->error->message, $decoded->error->code);

		$message = sprintf('%s (%s)', $decoded->message, $this->statusCode());

		if (isset($this->decoded()->errors)) {
			$errors = $this->decoded()->errors;

			$message .= $this->resolveAttributes($errors);
		}

		return $message;
	}

	/**
	 * resolves all known attributes
	 *
	 * @param stdClass $stdClass
	 *
	 * @return string
	 */
	private function resolveAttributes(stdClass $stdClass)
	{
		$attributes = array('action', 'hash', 'scope', 'data');

		$message = '';
		foreach ($attributes as $attribute) {
			$message .= $this->resolveAttribute($stdClass, $attribute);
		}

		return $message;
	}

	/**
	 * resolves an attribute
	 *
	 * @param stdClass $stdClass
	 * @param string $attribute
	 *
	 * @return string
	 */
	private function resolveAttribute(stdClass $stdClass, $attribute)
	{
		if (isset($stdClass->$attribute))
			return PHP_EOL . sprintf('  %s: %s', $attribute, implode(', ', $stdClass->$attribute));

		return '';
	}
}