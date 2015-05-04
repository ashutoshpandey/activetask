<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('name', 255);
            $table->string('display_name', 255);
            $table->string('email', 255);
            $table->string('phone', 25);
            $table->string('password', 255);
            $table->string('gender', 6);
            $table->string('country', 255);
            $table->string('status', 20);

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
		Schema::table('users', function(Blueprint $table)
		{

		});
	}

}
