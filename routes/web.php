<?php

use App\Invoice;
use App\Item;
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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('parse', 'ParseController@index');
Route::get('api', 'ApiTesterController@index');


Route::get('/', function () {

    // $invoices = Item::withMulti(['invoice_id', 'price', 'price2'], 'fff')->take(10)->get();
    return $invoices = Invoice::clearAp()->get();
    return $invoices = Invoice::get();
    // $invoices = Invoice::withMath(['id', 'name'])->take(10)->get();
    // $invoices = Invoice::withCount('items')->take(10)->get();
    dd($invoices);
    return view('welcome');
});
