<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request) {

		// verify recaptcha, if not in testing mode
		if (config('app.env') !== 'testing') {
			$key = config('services.recaptcha.secret_key');
			$captcha = request('recaptcha');
			$response = file_get_contents(
				"https://www.google.com/recaptcha/api/siteverify?secret=" . $key . "&response=" . $captcha
			);
			// use json_decode to extract json response
			$response = json_decode($response);
			if ($response->success === false) {
				return "recaptcha failed";
			}
	
			if ($response->success==true && $response->score <= 0.5) {
				return "recaptcha failed";
			}
		}
		

		if (auth()->check()) {
			auth()->user()->subscribe();
		} else if (!Subscriber::where(['email'=>request('email')])->exists()) {
			$key_found = false;
			while( ! $key_found) {
				$key = rand(0,999999999);
				$key_found = !Subscriber::where(['key'=>$key])->exists();
			}
			Subscriber::create([
				'email'=>request('email'),
				'key' => $key
			]);
		}
		return back();
	}

	public function destroy($key) {
		if (auth()->check()) {
			auth()->user()->unsubscribe();
		} else {
			Subscriber::where(['key'=>$key])->delete();
		}
	}
}
