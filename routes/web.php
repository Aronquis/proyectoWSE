<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    $ciudades=DB::table('DbWSE.dbo.AlmacenProductos')->get();
    dd($ciudades);
    //$contents = Storage::disk()->get('FotosServiciosGastos/2020-08/2018-dodge-challenger-srt-demon.jpg');
    //return Response::make($contents)->header("Content-Type", 'image/jpg');

});
Route::get('imagenes/{nombre}', function ($nombre) {
    $contents = Storage::disk()->get('FotosServiciosGastos/'.$nombre);
    return Response::make($contents)->header("Content-Type", 'image/jpg');

});
