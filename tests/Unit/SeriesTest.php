<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeriesTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function it_knows_what_articles_it_owns() {
		$series = factory('App\Series')->create();
		$a1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$a2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$a3 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>3
		]);
		$this->assertInstanceOf('\App\Article',$series->articles()->first());
		$this->assertEquals($a1->id,$series->articles[0]->id);
		$this->assertEquals($a3->id,$series->articles[2]->id);
	}



}
