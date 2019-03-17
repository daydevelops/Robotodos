<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscriptionTest extends TestCase
{
	use DatabaseMigrations;
	/** @test */
	public function a_user_can_subscribe() {
		$res = $this->json('POST','/subscribe',[
			'email'=>'test@test.com'
		]);
		echo json_encode($res);
		// $this->assertDatabaseHas('subscribers',['email'=>'test@test.com']);
	}

}
