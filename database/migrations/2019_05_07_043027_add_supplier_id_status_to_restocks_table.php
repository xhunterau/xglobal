<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplierIdStatusToRestocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restocks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('supplier_id');
            $table->char('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restocks', function (Blueprint $table) {
            //
            $table->dropColumn('supplier_id');
            $table->dropColumn('status');
        });
    }
}
