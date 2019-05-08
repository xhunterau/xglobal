<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bill_no');
            $table->unsignedBigInteger('supplier_id');
            $table->datetime('due_at');
            $table->decimal('subtotal', 19, 4);
            $table->decimal('commission', 19,4);
            $table->decimal('local_freight', 19, 4);
            $table->decimal('exchange_rate', 19, 4);
            $table->decimal('paid', 19, 4);
            $table->decimal('balance', 19, 4);
            $table->string('status');
            $table->mediumText('comments')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('bills');
    }
}
