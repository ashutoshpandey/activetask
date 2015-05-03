<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskitemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_items', function(Blueprint $table)
		{
            $table->increments('id');

            $table->unsignedInteger('task_id');
            $table->unsignedInteger('user_id');         // added by

            $table->string('name', 255);
            $table->string('description', 1000);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status', 20);

            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::table('task_items', function(Blueprint $table)
		{
			//
		});
	}

}
