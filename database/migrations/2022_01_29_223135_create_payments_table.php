<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
	public function up()
	{
		Schema::create('payments', function (Blueprint $table) {
			$table->increments('id');
			$table->string('payment_code');
			$table->string('name', 256);
			$table->string('postal_code', 256);
			$table->string('prefectures', 256);
			$table->string('municipalities', 256);
			$table->string('address', 256);
			$table->unsignedInteger('user_id')->comment('userテーブルと紐付けるため');
			$table->unsignedInteger('cart_id')->comment('何をいくつ買ったかを把握するため');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('payments');
	}
}
