<?php namespace DoubleOptIn\ClientApi\Exceptions;

/**
 * Class KeyTooLongException
 *
 * CryptographyEngine uses keys and mcrypt library. This has key sizes as limitation.
 *
 * @package DoubleOptIn\ClientApi\Exceptions
 */
class KeyTooLongException extends ClientApiException
{
}