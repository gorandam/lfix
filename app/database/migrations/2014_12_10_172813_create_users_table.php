<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Users table
		Schema::create('users', function($table)
	    {
			$table->increments('id');
	        $table->string('email')->unique();
	        $table->string('password', 255);
	        $table->string('name');
	        $table->integer('group')->references('id')->on('users_groups');
	        $table->timestamps();
	    });   
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop table
		Schema::drop('users');
	}

}
