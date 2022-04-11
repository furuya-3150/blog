<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddresseesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addressees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 256);
            $table->string('postal_code', 256);
            $table->string('prefectures', 256);
            $table->string('municipalities', 256);
            $table->string('address', 256);
            $table->string('telephone_number', 256);
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addressees');
    }
}
