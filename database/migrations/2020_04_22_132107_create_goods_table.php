<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable()->unsigned();
            $table->integer('price');
            $table->integer('price2');
            $table->timestamps();
        });

        Schema::create('good_invoice', function (Blueprint $table) {
            $table->integer('invoice_id')->nullable();
            $table->integer('good_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('good_invoice');
        Schema::dropIfExists('goods');
    }
}
