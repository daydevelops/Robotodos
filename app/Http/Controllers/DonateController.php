<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class DonateController extends Controller
{
    public function index() {
		$trending_article = Article::orderBy('view_count','DESC')->first();
        return view('coffee',compact('trending_article'));
    }
}
