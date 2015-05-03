<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupmembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_members', function(Blueprint $table)
		{
            $table->increments('id');

            $table->unsignedInteger('group_id');
            $table->unsignedInteger('user_id');         // member id

            $table->string('status', 20);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group_id')->references('id')->on('user_groups')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('group_members', function(Blueprint $table)
		{
			//
		});
	}

}
