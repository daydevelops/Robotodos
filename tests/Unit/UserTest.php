<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function a_user_can_retrieve_its_subscription() {
		$this->signIn();
		$user = auth()->user();
		Subscriber::create([
			'email'=>$user->email,
			'user_id'=>$user->id
		]);
		$this->assertInstanceOf('\App\Subscriber',$user->subscription);
	}
	/** @test */
	public function a_user_can_subscribe_and_unsubscribe() {
		$this->signIn();
		$user = auth()->user();
		$user->subscribe();
		$this->assertDatabaseHas('subscribers',[
			'email'=>$user->email,
			'user_id'=>$user->id
		]);
		$user->unsubscribe();
		$this->assertDatabaseMissing('subscribers',[
			'email'=>$user->email,
			'user_id'=>$user->id
		]);
	}



}
