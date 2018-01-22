<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Users Groups table
		Schema::create('users_groups', function($table)
	    {
			$table->increments('id');
	        $table->string('name');
	    });   
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop users_groups
		Schema::drop('users_groups');
	}

}
