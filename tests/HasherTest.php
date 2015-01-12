<?php

class HasherTest extends TestCase
{
	/* FIXTURES*/
	private $siteToken = '9814beca949ff6f4d57ef5220fddf50e6fb5cdc90eeb4479a3cd3ea94a549900';

	private $email = 'test@example.com';

	/* RESULTS */
	private $hash = '407d60d1fd49dfea0a3ee47b1e666c62181af39ef53bedc16ed163add22d8f12edd311de657a652de833116ccdb55d3cb8044ae3e4f1636bbcb3e7714dd09185dca435a29d9f794ae637c776c66d2a67e70dc827d166936e7d7d16e7c7eafdc75cf82d3830e77b42f6dae3661b87e102cd2d1a5cb51b50b533264256ab94e9';

	/** @test */
	public function it_can_hash_it_the_right_way_like_javascript_api()
	{
		$hasher = new \DoubleOptIn\ClientApi\Security\Hasher($this->siteToken);

		$hashed = $hasher->hash($this->email);
		$this->assertEquals($this->hash, $hashed);
	}
}