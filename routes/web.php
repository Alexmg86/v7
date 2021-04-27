<?php

use App\Invoice;
use App\Item;
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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('parse', 'ParseController@index');
Route::get('api', 'ApiTesterController@index');
Route::post('api', 'ApiTesterController@action');


Route::get('/', function () {
    $invoices = Invoice::whereCurrentYear()->count();
    // dd($invoices);

    // $invoices = Invoice::withSum('items:price')->getLikeSql();
    // dd($invoices);
    return view('welcome');
    // return view('test', compact('invoices'));
});
