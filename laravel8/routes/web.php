<?php

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
Route::get('/','App\Http\Controllers\MyController@index');
Route::view('/HomePage','HomePage');
Route::view('/ViewCustomers','ViewCustomers');
Route::view('/TransferMoney','TransferMoney');
Route::view('/ViewTransactionHistory','ViewTransactionHistory');
Route::get('GetTransactionHistoryData/','App\Http\Controllers\MyController@GetTransactionHistoryData');
Route::get('GetCurrentBalByCusId/{CusId}','App\Http\Controllers\MyController@GetCurrentBalByCusId');
Route::post('/ShowTransaction','App\Http\Controllers\MyController@SaveTransaction');
Route::get('ShowCustomers/','App\Http\Controllers\MyController@ShowCustomers');