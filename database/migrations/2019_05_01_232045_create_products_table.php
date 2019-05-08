<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sku');
            $table->unsignedInteger('carton_quantity');
            $table->decimal('carton_weight', 8, 2);
            $table->decimal('carton_length', 8, 2);
            $table->decimal('carton_width', 8, 2);
            $table->decimal('carton_height', 8, 2);
            $table->decimal('sea_freight', 19, 4)->default(0); //door to door
            $table->decimal('price_usd', 19, 4)->default(0);
            $table->decimal('price_cny', 19, 4)->default(0);
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
        Schema::dropIfExists('products');
    }
}
