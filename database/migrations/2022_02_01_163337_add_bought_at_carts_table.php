<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBoughtAtCartsTable extends Migration
{
    public function up()
    {
		Schema::table('carts', function (Blueprint $table) {
			$table->timestamp('bought_at')->nullable()->after('updated_at');
        });
    }
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            //
        });
    }
}
