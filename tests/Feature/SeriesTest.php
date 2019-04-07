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
	public function an_admin_can_update_a_series_name() {
		$series = factory('App\Series')->create(['name'=>'foobar']);
		$this->json('patch','api/series/'.$series->id,['name'=>'lorem_ipsum']);
		$this->assertDatabaseHas('series',['name'=>'lorem_ipsum']);
	}

	/** @test */
	public function an_admin_can_add_an_article_to_the_end_of_a_series() {
		$article = factory('App\Article')->create();
		$article2 = factory('App\Article')->create();
		$series = factory('App\Series')->create();
		// dd('api/series/'.$series->id.'/add/'.$article->id);
		$this->json('patch','api/series/'.$series->id.'/add/'.$article->id);
		$this->json('patch','api/series/'.$series->id.'/add/'.$article2->id);
		$this->assertEquals($series->id,$article->fresh()->series_id);
		$this->assertEquals(2,$article2->fresh()->number_in_series);
	}

	/** @test */
	public function an_article_can_only_belong_to_one_series() {
		$article = factory('App\Article')->create();
		$series = factory('App\Series')->create();
		$series2 = factory('App\Series')->create();
		// dd('api/series/'.$series->id.'/add/'.$article->id);
		$this->json('patch','api/series/'.$series->id.'/add/'.$article->id);
		$this->assertEquals($series->id,$article->fresh()->series_id);
		$this->json('patch','api/series/'.$series2->id.'/add/'.$article->id);
		$this->assertEquals($series2->id,$article->fresh()->series_id);
	}

	/** @test */
	public function an_admin_can_remove_an_article_from_a_series() {
		$article = factory('App\Article')->create();
		$series = factory('App\Series')->create();
		$series->add($article);
		$this->assertEquals($series->id,$article->fresh()->series_id);
		$this->json('delete','api/series/'.$series->id.'/delete/'.$article->id);
		$this->assertEquals(null,$article->fresh()->series_id);
	}

	/** @test */
	public function removing_an_art_updates_the_position_of_following_arts() {
		$articles = factory('App\Article',5)->create();
		$series = factory('App\Series')->create();
		foreach($articles as $a) {
			$a->update([
				'series_id'=>$series->id,
				'number_in_series'=>$a->id
			]);
		}
		$this->json('delete','api/series/'.$series->id.'/delete/'.$articles[2]->id);
		$this->assertEquals(['1','2','3','4'],$series->articles->pluck('number_in_series')->toArray());
	}

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
