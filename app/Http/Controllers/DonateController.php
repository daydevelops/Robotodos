<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;
use Stripe\Exception\CardException;

class DonateController extends Controller
{
    public function index() {
		$trending_article = Article::orderBy('view_count','DESC')->first();
        return view('coffee.coffee',compact('trending_article'));
    }

    public function charge(Request $request) {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            \Stripe\Charge::create([
                'amount' => request('cost')*100,
                'currency' => 'cad',
                'source' => request('id')
            ]);
            return response()->json([
                'status'=>true,
                'cost'=>request('cost')
            ]);
        } catch (CardException $e) {
            return response()->json([
                'status'=>false
            ]);
        }
    }

    public function success() {
		$trending_article = Article::orderBy('view_count','DESC')->first();
        return view('coffee.success',compact('trending_article'));
    }
}
