<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskcommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_comments', function(Blueprint $table)
		{
            $table->increments('id');

            $table->unsignedInteger('user_id');

            $table->string('comment', 255);

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
		Schema::table('task_comments', function(Blueprint $table)
		{
			//
		});
	}

}
