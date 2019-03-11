<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = App\User::where(['email'=>'adamday1618@gmail.com'])->first()->id;
		factory(Comment::class,10)->create([
			'commentable_id'=>App\Article::where(['user_id'=>$user])->first()->id,
			'commentable_type'=>'articles'
		]);
        factory(Comment::class, 100)->create();
    }
}
