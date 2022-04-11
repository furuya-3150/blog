<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
	public function up()
	{
		Schema::create('reviews', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('item_id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('stars')->nullable();
			$table->string('comment', 256)->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('reviews');
	}
}
