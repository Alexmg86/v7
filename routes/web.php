<?php

use App\Invoice;
use App\Item;
use App\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//select cs.id, name, price from invoices cs left join( select sum(price) as price, invoice_id from items group by invoice_id )x on x.invoice_id = cs.id

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::get('/', function () {

    $raw = \DB::raw("@i := coalesce(@i + 1, 1) ranking, id, invoice_id");
    $items = Item::whereIn('invoice_id', [1,2])
    ->orderBy('invoice_id')->orderBy('id')->addSelect($raw)->groupBy('invoice_id')->groupBy('id')
    ->get()->where('ranking', '=', 1.0);

    // $items = \DB::select(\DB::raw('@total := @total + x as total_x, id, invoice_id'))
    // ->from(DB::raw('items, (select @total := 0) as var'))
    // ->whereIn('invoice_id', [1,2])
    // ->get();

    // $select = \DB::raw("@i := coalesce(@i + 1, 1) ranking, items.*")


    // $items = Items::addSelect($select);
    dd($items);

    $start = memory_get_usage();
    // $invoices = Invoice::with('items')->get();
    $invoices = Invoice::whereIn('id', [1,2])->get();
    // foreach ($invoices as $invoice) {
    //     $invoice->load(['items' => function ($query) {
    //         $query->limit(1);
    //     }]);
    // }
    $invoices->loadLimit('items:1');
    // $invoices->loadLimit(['goods:1', 'items:1' => function ($query) {
    //     $query->orderBy('id', 'desc');
    // }]);
    $end = memory_get_usage();
    $time = $start / (1024 * 1024);
    $time2 = $end / (1024 * 1024);
    app('debugbar')->info($time, $time2);
    // dd($invoices, $start / (1024 * 1024), $end / (1024 * 1024));
    return view('welcome');
});

Route::get('/test', function () {
    // $invoices = Invoice::with('items')->get();
    $invoices = Invoice::join('items')->get();
    $invoices = Invoice::withCount('items')->get();
    // $invoices = Invoice::withSum('items.price')->get();
    dd($invoices);
});
