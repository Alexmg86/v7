<?php

use App\Good;
use App\Invoice;
use App\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsHasManyAndBelongsToMany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('price');
            $table->integer('price2');
            $table->timestamps();
        });

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

        $names = ['первый', 'второй'];
        foreach ($names as $name) {
            $invoive = Invoice::create(['name' => $name]);
            $items = [];
            $goodsIds = [];
            for ($i = 1; $i < 100; $i++) {
                $items[] = new Item(['invoice_id' => $invoive->id, 'price' => $i, 'price2' => $i + 1]);
                $good = Good::create(['invoice_id' => $invoive->id, 'price' => $i, 'price2' => $i + 1]);
                $goodsIds[] = $good->id;
                if (count($items) == 50) {
                    $invoive->items()->saveMany($items);
                    $items = [];

                    $invoive->goods()->sync($goodsIds);
                    $goodsIds = [];
                }
            }
        }
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
        Schema::dropIfExists('items');
        Schema::dropIfExists('invoices');
    }
}
