<?php

use DoubleOptIn\ClientApi\Security\Crypter;
use DoubleOptIn\ClientApi\Security\Hasher;

class CrypterTest extends TestCase
{
	/* FIXTURES*/
	private $siteToken = '9814beca949ff6f4d57ef5220fddf50e6fb5cdc90eeb4479a3cd3ea94a549900';

	private $email = 'test@example.com';

	private $plaintextMessage = 'Testmessage';

	/* RESULTS */

	/** @test */
	public function it_can_be_encrypted_and_decrypted()
	{
		$crypter = new Crypter();
		$hasher = new Hasher($this->siteToken);

		$key = $hasher->key($this->email);
		$expectedKey = $hasher->hash($this->email . $this->siteToken);
		$this->assertEquals($expectedKey, $key);

		$encryptedMessage = $crypter->encrypt($this->plaintextMessage, $key);

		$expected = Crypter::IDENTIFIER . Crypter::SEPARATOR_ALGORITHM . strlen($this->plaintextMessage) . Crypter::SEPARATOR_CRYPTO_PARTS;
		$this->assertEquals($expected, substr($encryptedMessage, 0, strlen($expected)));

		$resolvedMessage = $crypter->decrypt($encryptedMessage, $key);
		$this->assertEquals($this->plaintextMessage, $resolvedMessage);
	}

	/** @test */
	public function it_can_decrypt_javascript_encrypted_message()
	{
		$hash = '407d60d1fd49dfea0a3ee47b1e666c62181af39ef53bedc16ed163add22d8f12edd311de657a652de833116ccdb55d3cb8044ae3e4f1636bbcb3e7714dd09185dca435a29d9f794ae637c776c66d2a67e70dc827d166936e7d7d16e7c7eafdc75cf82d3830e77b42f6dae3661b87e102cd2d1a5cb51b50b533264256ab94e9';
		$data = 'slowaes:11 41bc1eacf6ce685c8eb7649da0d080995223165277af8bc068c90f7eb831d5ae 97be775203f003fef3c808e4b588c69b';

		$crypter = new Crypter();
		$hasher = new Hasher($this->siteToken);

		$hashed = $hasher->hash('test@example.com');
		$this->assertEquals($hash, $hashed);

		$key = $hasher->key($this->email);

		$resolvedMessage = $crypter->decrypt($data, $key);
		$this->assertEquals($this->plaintextMessage, $resolvedMessage);
	}

	/** @test */
	public function it_does_not_fail_on_empty_message_for_decryption()
	{
		$crypter = new Crypter();
		$hasher = new Hasher($this->siteToken);

		$this->assertEmpty($crypter->decrypt('', $hasher->key($this->email)));
		$this->assertEmpty($crypter->decrypt(null, $hasher->key($this->email)));
	}

	/** @test */
	public function it_does_not_fail_on_empty_message_for_encryption()
	{
		$crypter = new Crypter();
		$hasher = new Hasher($this->siteToken);

		$this->assertNotEmpty($crypter->encrypt('', $hasher->key($this->email)));
		$this->assertNotEmpty($crypter->encrypt(null, $hasher->key($this->email)));
	}
}