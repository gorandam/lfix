<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Jobs table
		Schema::create('jobs', function($table)
	    {
			$table->increments('id');
	        $table->string('title');
	        $table->integer('category')->references('id')->on('categories');
	        $table->integer('location')->references('id')->on('locations');
	        $table->text('description');
	        $table->integer('assigned_to')->references('id')->on('users');
	        $table->string('priority');
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
		Schema::drop('jobs');
	}

}
