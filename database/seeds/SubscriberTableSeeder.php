<?php

use Illuminate\Database\Seeder;

class SubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory("App\Subscriber",10)->create();
    }
}
