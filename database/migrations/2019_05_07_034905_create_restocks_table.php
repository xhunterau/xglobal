<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sku');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('require_qty');
            $table->unsignedInteger('order_qty')->default(0);
            $table->datetime('runout_at');
            $table->datetime('deliver_at')->nullable();
            $table->string('bill_no')->nullable();
            $table->mediumText('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restocks');
    }
}
