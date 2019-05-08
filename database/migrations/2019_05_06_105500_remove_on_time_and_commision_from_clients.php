<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveOnTimeAndCommisionFromClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_product', function (Blueprint $table) {
            //
            $table->dropColumn('on_time');
            $table->dropColumn('commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_product', function (Blueprint $table) {
            //
            $table->string('on_time');
            $table->string('commission');
        });
    }
}
