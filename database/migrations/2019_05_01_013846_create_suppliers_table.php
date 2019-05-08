<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('contact_person')->nullable();
            $table->string('mobile')->nullable();
            $table->string('landline')->nullable();
            $table->string('qq')->nullable();
            $table->string('wechat')->nullable();
            $table->string('aliwang')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('alipay')->nullable();
            $table->text('bank')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
