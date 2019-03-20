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
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'status' => true,
                'is_admin' => true,
                'confirm_code' => str_random(64),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        ];
		if (User::where(['email'=>'admin@admin.com'])->count()==0) {
       		DB::table('users')->insert($users);
		}
		if (User::where(['email'=>'adamday1618@gmail.com'])->count()==0) {
			factory(User::class,1)->create([
				'name' => 'adam',
				'email' => 'adamday1618@gmail.com',
				'password' => Hash::make('adam'),
			]);
		}
        factory(User::class, 10)->create();
    }
}
