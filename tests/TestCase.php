<?php

namespace Tests;

use App\User;
use Laravel\Passport\Passport;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected function setUp(): void {
		parent::setUp();
		$this->disableExceptionHandling();
	}
	protected function disableExceptionHandling() {
		$this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
		$this->app->instance(ExceptionHandler::class, new class extends Handler {
			public function __construct() {

			}
			public function report(\Exception $e) {

			}
			public function render($request, \Exception $e) {
				throw $e;
			}
		});
	}
	protected function withExceptionHandling() {
		$this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
		return $this;
	}

    public function actingAsAdmin()
    {
        Passport::actingAs(
            factory(User::class, 'admin')->create(),
            ['user', 'article']
        );

        return $this;
    }

	protected function signIn($user=null) {
		$user = $user ?: factory('App\User')->create();
		$this->be($user);
		return $this;
	}

	protected function signout() {
		Auth::logout();
	}

}
