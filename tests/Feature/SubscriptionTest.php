<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscriptionTest extends TestCase
{
	use DatabaseMigrations;

	protected $email = 'test@test.com';

	protected function subscribe() {
		$res = $this->json('POST','/subscribe',[
			'email'=>$this->email,
			'user_id'=>auth()->check() ?  auth()->id() : null,
		]);
		return $res;
	}


	/** @test */
	public function a_user_can_subscribe() {
		$this->subscribe();
		// echo json_encode($res);
		$this->assertDatabaseHas('subscribers',['email'=>$this->email]);
	}

	/** @test */
	public function a_guest_can_not_subscribe_more_than_once() {
		$this->subscribe();
		$this->subscribe();
		$this->assertCount(1,Subscriber::where(['email'=>$this->email])->get());
	}

	/** @test */
	public function a_user_can_not_subscribe_more_than_once() {
		$this->signIn();
		$this->subscribe();
		$this->subscribe();
		$this->assertCount(1,Subscriber::where(['email'=>auth()->user()->email])->get());
	}

	/** @test */
	public function if_a_user_is_signed_in_their_user_info_is_saved() {
		$this->signIn();
		$this->subscribe();
		$user = auth()->user();
		$this->assertDatabaseHas('subscribers',[
			'email'=>$user->email,
			'user_id'=>$user->id
		]);
	}

	/** @test */
	public function a_user_can_unsubscribe() {
		$this->signIn();
		auth()->user()->subscribe();
		$res = $this->json('POST','/unsubscribe');
		$this->assertDatabaseMissing('subscribers',[
			'email'=>auth()->user()->email,
		]);
	}

	/** @test */
	public function a_guest_can_unsubscribe() {
		$this->subscribe();
		$this->assertDatabaseHas('subscribers',['email'=>$this->email]);
		$res = $this->json('POST','unsubscribe',['email'=>$this->email]);
		$this->assertDatabaseMissing('subscribers',['email'=>$this->email]);
	}

}
