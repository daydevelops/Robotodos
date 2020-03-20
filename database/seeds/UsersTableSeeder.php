<?php

use Carbon\Carbon;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => config('blog.admin_name'),
                'email' => config('blog.admin_email'),
                'password' => Hash::make(config('blog.admin_password')),
                'status' => true,
                'is_admin' => true,
                'confirm_code' => str_random(64),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        ];
		if (User::where(['email'=>config('blog.admin_email')])->count()==0) {
       		DB::table('users')->insert($users);
		}
		if (User::where(['email'=>'test@test.com'])->count()==0) {
			factory(User::class,1)->create([
				'name' => 'test',
				'email' => 'test@test.com',
				'password' => Hash::make('test'),
			]);
		}
        factory(User::class, 10)->create();
    }
}
