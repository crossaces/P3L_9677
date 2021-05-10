<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register','Api\AuthController@register');//register
Route::post('login','Api\AuthController@login');//login



Route::get('pesanan','Api\Pesananontroller@index');//show
Route::get('pesanan/{id}','Api\Pesananontroller@show');//show with id
Route::post('pesanan','Api\Pesananontroller@store');// insert
Route::put('pesanan/{id}','Api\Pesananontroller@update');//update
Route::put('pesananStatus/{id}','Api\Pesananontroller@updateStatus');//update status
Route::delete('pesanan/{id}','Api\Pesananontroller@destroy');//delete

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('bahank','Api\BahanKController@index');//show
    Route::get('bahank/{id}','Api\BahanKController@show');//show with id
    Route::post('bahank','Api\BahanKController@store');// insert
    Route::put('bahank/{id}','Api\BahanKController@update');//update
    Route::delete('bahank/{id}','Api\BahanKController@destroy');//delete
    Route::put('bahankh/{id}','Api\BahanKController@delete');//soft delete 
   

    Route::get('bahan','Api\BahanController@index');//show
    Route::get('cbahan','Api\BahanController@cekbahan');//show
    Route::get('bahanmenu','Api\BahanController@untukmenu');//showbahans
    Route::get('bahan/{id}','Api\BahanController@show');//show with id
    Route::get('bahant/{id}','Api\BahanController@showtable');//show with id
    Route::post('bahan','Api\BahanController@store');// insert
    Route::put('bahan/{id}','Api\BahanController@update');//update
    Route::delete('bahan/{id}','Api\BahanController@destroy');//delete
    Route::put('bahanh/{id}','Api\BahanController@delete');//soft delete 

    Route::get('bahanm','Api\BahanMController@index');//show
    Route::get('bahanm/{id}','Api\BahanMController@show');//show with id
    Route::post('bahanm','Api\BahanMController@store');// insert
    Route::put('bahanm/{id}','Api\BahanMController@update');//update
    Route::delete('bahanm/{id}','Api\BahanMController@destroy');//delete
    Route::put('bahanmh/{id}','Api\BahanMController@delete');//soft delete 

    Route::get('jabatan','Api\JabatanController@index');//show

    Route::get('customer','Api\CustomerController@index');//show
    Route::get('customer/{id}','Api\CustomerController@show');//show with id
    Route::post('customer','Api\CustomerController@store');// insert
    Route::put('customer/{id}','Api\CustomerController@update');//update
    Route::delete('customer/{id}','Api\CustomerController@destroy');//delete
    Route::put('customerh/{id}','Api\CustomerController@delete');//soft delete 

    Route::get('meja','Api\MejaController@index');//show
    Route::get('meja/{id}','Api\MejaController@show');//show with id
    Route::post('meja','Api\MejaController@store');// insert
    Route::post('getmeja','Api\MejaController@getMeja');
    Route::put('meja/{id}','Api\MejaController@update');//update
    Route::put('mejaStatus/{id}','Api\MejaController@updateStatus');//update status
    Route::delete('meja/{id}','Api\MejaController@destroy');//delete
    Route::put('mejah/{id}','Api\MejaController@hapus');//delete

    Route::get('menu','Api\MenuController@index');//show
    Route::get('menu/{id}','Api\MenuController@show');//show with id
    Route::post('menu','Api\MenuController@store');// insert
    Route::post('menu/{id}','Api\MenuController@update');//update   
    Route::put('menu/{id}','Api\MenuController@delete');//soft delete 
    Route::delete('menu/{id}','Api\MenuController@destroy');//delete

    Route::get('kartu','Api\KartuController@index');//show
    Route::get('kartu/{id}','Api\KartuController@show');//show with id
    Route::post('kartu','Api\KartuController@store');// insert
    Route::put('kartu/{id}','Api\KartuController@update');//update
    Route::delete('kartu/{id}','Api\KartuController@destroy');//delete

    Route::get('reservasi','Api\ReservasiController@index');//show
    Route::get('reservasi/{id}','Api\ReservasiController@show');//show with id
    Route::post('reservasi','Api\ReservasiController@store');// insert
    Route::put('reservasi/{id}','Api\ReservasiController@update');//update
    Route::delete('reservasi/{id}','Api\ReservasiController@destroy');//delete
    Route::put('reservasih/{id}','Api\ReservasiController@delete');//soft delete 


    Route::get('karyawan','Api\AuthController@index');//get semua karyawan
    Route::post('updatePic/{id}','Api\AuthController@updatePic');//update gambar karyawan
    Route::put('update/{id}','Api\AuthController@update');//update karyawan
    route::put('change/{id}','Api\AuthController@changePassword');//ganti password
    Route::put('updatestatus/{id}','Api\AuthController@updateStatus');
    Route::get('karyawan/{id}','Api\AuthController@show');//show
    Route::get('jabatan/{id}','Api\JabatanController@show');//get Jabatan
    
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
