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
			Subscriber::create(['email'=>request('email')]);
		}
		return back();
	}

	public function destroy() {
		if (auth()->check()) {
			auth()->user()->unsubscribe();
		} else {
			Subscriber::where(['email'=>request('email')])->delete();
		}
	}
}
