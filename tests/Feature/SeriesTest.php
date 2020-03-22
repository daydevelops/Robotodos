<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeriesTest extends TestCase
{
	use DatabaseMigrations;

	public function setup():void {
		parent::setup();
		$this->artisan('db:seed', ['--class' => 'PermissionTableSeeder']);
		$this->actingAsAdmin();
	}

	/** @test */
	public function an_admin_can_see_a_list_of_series_in_the_dashboard() {
		$series = factory('App\Series',2)->create();
		$response = $this->get('/api/series');
		$response->assertSee($series[0]->title);
		$response->assertSee($series[1]->title);
	}

	/** @test */
	public function an_admin_can_create_a_series() {
		$this->post('/api/series/new',[
			'name'=>'foobar',
			'description'=>'lorem ipsum'
		]);
		$this->assertDatabaseHas('series',['name'=>'foobar']);
	}

	/** @test */
	public function an_admin_can_update_a_series_name() {
		$series = factory('App\Series')->create(['name'=>'foobar']);
		$this->json('patch','api/series/'.$series->id,[
			'name'=>'lorem_ipsum',
			'description'=>'lorem ipsum'
		]);
		$this->assertDatabaseHas('series',['name'=>'lorem_ipsum']);
	}


	/** @test */
	public function an_admin_can_change_the_order_of_articles_in_a_series() {
		$series = factory('App\Series')->create();
		$art1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$art2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$art3 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>3
		]);
		$this->json('patch','api/series/order/'.$series->id,['articles'=>[3,1,2]]);
		$this->assertEquals(1,$art3->refresh()->number_in_series);
		$this->assertEquals(2,$art1->refresh()->number_in_series);
		$this->assertEquals(3,$art2->refresh()->number_in_series);
	}

	/** @test */
	public function articles_can_be_deleted_by_updating_the_order() {

			$series = factory('App\Series')->create();
			$art1 = factory('App\Article')->create([
				'series_id'=>$series->id,
				'number_in_series'=>1
			]);
			$art2 = factory('App\Article')->create([
				'series_id'=>$series->id,
				'number_in_series'=>2
			]);
			$art3 = factory('App\Article')->create([
				'series_id'=>$series->id,
				'number_in_series'=>3
			]);
			$this->json('patch','api/series/order/'.$series->id,['articles'=>[3,1]]);
			$this->assertEquals(1,$art3->refresh()->number_in_series);
			$this->assertEquals(2,$art1->refresh()->number_in_series);
			$this->assertEquals(null,$art2->refresh()->number_in_series);
	}

	/** @test */
	public function articles_can_be_added_by_updating_the_order() {
		$series = factory('App\Series')->create();
		$art1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$art2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$art3 = factory('App\Article')->create();

		$this->json('patch','api/series/order/'.$series->id,['articles'=>[3,1,2]]);
		$this->assertEquals(1,$art3->refresh()->number_in_series);
		$this->assertEquals(2,$art1->refresh()->number_in_series);
		$this->assertEquals(3,$art2->refresh()->number_in_series);

	}

	/** @test */
	public function an_admin_can_delete_a_series() {
		$series = factory('App\Series')->create();
		$art1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$this->json('delete','api/series/'.$series->id);
		$this->assertDatabaseMissing('series',['name'=>$series->name]);
		$this->assertEquals(null,$art1->fresh()->series_id);
	}

	/** @test */
	public function users_can_view_a_list_of_series() {
		$series = factory('App\Series')->create();
		$this->get('series')->assertSee($series->name);
	}

	/** @test */
	public function users_can_view_all_articles_in_a_series() {

		$series = factory('App\Series')->create();
		$art = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);

		$this->get('series/'.$series->id)->assertSee($art->title);
	}

	/** @test */
	public function next_article_in_the_series_is_recommended() {

		$series = factory('App\Series')->create();
		$art1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$art2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$this->get($art1->slug)->assertSee($art2->title);

	}
}
