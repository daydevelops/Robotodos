<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('nickname')->nullable();
            $table->string('avatar')->default('/images/default.jpg');
            $table->string('email')->unique();
            $table->string('confirm_code', 64)->unique()->nullable();
            $table->tinyInteger('status')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->string('password');
            $table->string('github_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->enum('email_notify_enabled', ['yes',  'no'])->default('yes')->index();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
