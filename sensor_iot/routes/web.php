<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/sensors/index', 'RegisterSensorController@index')->name('home');
Route::resource('sensors','RegisterSensorController');
Route::resource('sensor','SensorController');
Route::get('/sensor/remove/{id}', 'SensorController@remove')->name('sensor.remove');
