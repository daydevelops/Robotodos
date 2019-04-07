<?php

namespace App\Http\Controllers\Api;

use \App\Series;
use \App\Article;
use Illuminate\Http\Request;

class SeriesController extends ApiController
{
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		$keyword = $request->get('keyword');

		$seriess = Series::checkAuth()
		->when($keyword, function ($query) use ($keyword) {
			$query->where('title', 'like', "%{$keyword}%");
		})
		->orderBy('created_at', 'desc')->paginate(10);

		return $this->response->collection($seriess);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		//
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'name' => 'required|max:140',
		]);
		Series::create($validatedData);
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		//
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, Series $series)
	{
		$validatedData = $request->validate([
			'name' => 'required|max:140',
		]);
		$series->update($validatedData); 
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		//
	}

	public function addArticle(Series $series, Article $article) {
		$series->add($article);
	}
	public function destroyArticle(Series $series, Article $article) {
		$series->remove($article); 
	}
}
