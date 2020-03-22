<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
	/**
	* Run the database seeds.
	*
	* @return void
	*/
	public function run()
	{
		if (app('env')=='production') {
			$admin = [
					'name' => 'AdamDay',
					'email' => env('ADMIN_USER_EMAIL'),
					'password' => Hash::make(env('ADMIN_USER_PASS')),
					'status' => true,
					'is_admin' => true,
					'avatar'=>'/images/admin.jpg',
					'confirm_code' => str_random(64),
					'created_at'  => Carbon::now(),
					'updated_at'  => Carbon::now()

			];
			DB::table('users')->insert($admin);
			$this->call(PermissionTableSeeder::class);
		} else {
			$this->call(UsersTableSeeder::class);
			$this->call(CategoriesTableSeeder::class);
			$this->call(ArticlesTableSeeder::class);
			$this->call(DiscussionsTableSeeder::class);
			$this->call(CommentsTableSeeder::class);
			$this->call(TagsTableSeeder::class);
			$this->call(LinksTableSeeder::class);
			$this->call(VisitorsTableSeeder::class);
			$this->call(PermissionTableSeeder::class);
			$this->call(SubscriberTableSeeder::class);
		}
	}
}
