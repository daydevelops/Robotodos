<?php

use App\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(Article::class,1)->create([
			'user_id'=>App\User::where(['email'=>'adamday1618@gmail.com'])->first()->id
		]);
        factory(Article::class, 20)->create();
    }
}
