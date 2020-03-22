<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request) {
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
