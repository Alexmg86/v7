<?php

use App\Country;
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


Route::get('/', function () {

    $i = Invoice::like('name', 'пе')->get();
    app('debugbar')->info($i->count());
    // dd($i);
    // $invoices = Invoice::withSum('items:price')->remember(10 * 10)->sum('id');
    // $invoices = Invoice::withSum('items:price')->remember(10 * 10)->first();
    // dd($invoices);
    // $countries = Country::remember(10 * 10)->count();
    // $countries->loadOneLatest('posts');

    return view('welcome');
});

Route::get('/test', function () {
    // $invoices = Invoice::with('items')->get();
    $invoices = Invoice::join('items')->get();
    $invoices = Invoice::withCount('items')->get();
    // $invoices = Invoice::withSum('items.price')->get();
    dd($invoices);
});
