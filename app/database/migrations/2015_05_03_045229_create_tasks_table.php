<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
            Schema::create('tasks', function(Blueprint $table)
            {
                $table->increments('id');

                $table->unsignedInteger('user_id');
                $table->unsignedInteger('group_id');        // -1 => no group, otherwise group id

                $table->string('name', 255);
                $table->string('task_type', 255);           // fixed, no-time
                $table->string('allow_adding_task_item', 1);    // y/n
                $table->string('description', 1000);

                $table->dateTime('start_date');
                $table->dateTime('end_date');

                $table->string('status', 20);

                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('group_id')->references('id')->on('user_groups')->onDelete('cascade')->onUpdate('cascade');
            });
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
			//
		});
	}

}
