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
			'name'=>'foobar'
		]);
		$this->assertDatabaseHas('series',['name'=>'foobar']);
	}

	/** @test */
	public function an_admin_can_edit_a_series_details() {
		$series = factory('App\Series')->create(['name'=>'foobar']);
		$this->json('patch','api/series/'.$series->id,['name'=>'lorem_ipsum']);
		$this->assertDatabaseHas('series',['name'=>'lorem_ipsum']);

	}

	// /** @test */
	// public function an_admin_can_add_an_article_to_a_series() {
	//
	// }
	//
	// /** @test */
	// public function an_admin_can_remove_an_article_from_a_series() {
	//
	// }
	//
	// /** @test */
	// public function an_admin_can_change_the_order_of_articles_in_a_series() {
	//
	// }
	//
	// /** @test */
	// public function users_can_view_a_list_of_series() {
	//
	// }
	//
	// /** @test */
	// public function users_can_view_all_articles_in_a_series() {
	//
	// }
	//
	// /** @test */
	// public function next_article_in_the_series_is_recommended() {
	//
	// }

	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }
	//
	// /** @test */
	// public function {
	//
	// }

}
