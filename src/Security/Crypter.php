<?php namespace DoubleOptIn\ClientApi\Security;

/**
 * Class Crypter
 *
 *
 *
 * @package DoubleOptIn\ClientApi\Security
 */
class Crypter
{
	/**
	 * crypts the given text with a key
	 *
	 * @param string $text
	 * @param string $key
	 *
	 * @return string
	 */
	public function crypt($text, $key)
	{
		$td = mcrypt_module_open(MCRYPT_TWOFISH, '', MCRYPT_MODE_ECB, '');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$encrypted = mcrypt_generic($td, $text);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		return $encrypted;
	}
}