<?php

use App\Good;
use App\Invoice;
use App\Item;
use App\Point;
use App\SubItems;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $names = ['первый', 'второй'];
        foreach ($names as $name) {
            $invoive = Invoice::create(['name' => $name]);
            $items = [];
            for ($i = 1; $i < 1000000; $i++) {
                $items[] = new Item(['invoice_id' => $invoive->id, 'invoice_id_str' => $invoive->id, 'price' => $i, 'price2' => $i + 1]);
                if (count($items) == 4999) {
                    $invoive->items()->saveMany($items);
                    $items = [];
                }
            }
        }

        // foreach ($names as $name) {
        //     $invoive = Invoice::create(['name' => $name]);
        //     $goodsIds = [];
        //     for ($i = 1; $i < 1000000; $i++) {
        //         $good = Good::create(['invoice_id' => $invoive->id, 'price' => $i, 'price2' => $i + 1]);
        //         $goodsIds[] = $good->id;
        //         if (count($goodsIds) == 4999) {
        //             $invoive->goods()->sync($goodsIds);
        //             $goodsIds = [];
        //         }
        //     }
        //     $invoive->goods()->sync($goodsIds);
        // }


        // $items = Item::where('id', '<', 10)->get();
        // foreach ($items as $item) {
        //     $subitems = [];
        //     for ($i = 1; $i < 10; $i++) {
        //         $subitems[] = new SubItems(['item_id' => $item->id, 'item_id_str' => $item->id, 'price' => $i, 'price2' => $i + 1]);
        //     }
        //     $item->subitems()->saveMany($subitems);
        // }

        // for ($i = 1; $i < 10; $i++) {
        //     for ($p = 1; $p < 10; $p++) {
        //         Point::create(['category_id' => $i, 'name' => 'name', 'price' => $i * $p]);
        //     }
        // }
    }
}
