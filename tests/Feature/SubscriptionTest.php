<?php

namespace Tests\Feature;

use App\Mail\NewArticlePublished;
use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Mail;
use App\Jobs\NotifySubscribers;

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

	/** @test */
	public function an_admin_can_send_a_test_notification_for_a_post() {
		$post = factory('App\Article')->create();
		$this->actingAsAdmin(); // why is this performing 2 assertions?

		Mail::fake();
		Mail::assertNothingSent();
		$response = $this->post('/api/article/notifyTest/'.$post->id);
		Mail::assertSent(NewArticlePublished::class);
		
	}
	
	/** @test */
	public function an_admin_can_send_notifications_for_a_post() {
		$post = factory('App\Article')->create();
		$this->actingAsAdmin(); // why is this performing 2 assertions?

		Mail::fake();
		Queue::fake();
		Mail::assertNothingSent();
		$response = $this->post('/api/article/notify/'.$post->id);
		Queue::assertPushed(NotifySubscribers::class);
	}
}
