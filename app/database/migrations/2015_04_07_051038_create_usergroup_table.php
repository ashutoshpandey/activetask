<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsergroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_groups', function(Blueprint $table)
		{
            $table->increments('id');

            $table->unsignedInteger('user_id');         // creator

            $table->string('name', 255);
            $table->string('status', 20);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_groups', function(Blueprint $table)
		{
			//
		});
	}

}
