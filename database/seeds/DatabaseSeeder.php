<?php

use App\Invoice;
use App\Item;
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
        $names = ['первый', 'второй', 'первый', 'второй', 'первый', 'второй', 'первый', 'второй', 'первый', 'второй'];
        foreach ($names as $name) {
            $invoive = Invoice::create(['name' => $name]);
            $items = [];
            $goodsIds = [];
            for ($i = 1; $i < 100; $i++) {
                $items[] = new Item(['invoice_id' => $invoive->id, 'price' => $i, 'price2' => $i + 1]);
                if (count($items) == 50) {
                    $invoive->items()->saveMany($items);
                    $items = [];
                }
            }
        }
    }
}
