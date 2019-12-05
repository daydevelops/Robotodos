<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArticleTest extends TestCase
{
	use DatabaseMigrations;

	public function setup():void {
		parent::setup();
	}

    /** @test */
	public function some_articles_are_not_shown_for_guests() {
		$free_article = factory('App\Article')->create();
		$sub_article = factory('App\Article')->create(['needs_account'=>true]);

        $response = $this->get('/'.$free_article->slug);
        $response->assertSee($free_article->content['raw']);

        $response = $this->get('/'.$sub_article->slug);
        $response->assertDontSee($sub_article->content['raw']);
        $response->assertSee('Sorry, but this article has been restricted to user access only');
    }
}