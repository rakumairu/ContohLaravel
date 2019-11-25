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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

/**
 * CityOptions Routes
 */
Route::get('/city', 'CityController@index')->name('city');
Route::post('/city/api_city_list', 'CityController@api_city_list')->name('city.list');
Route::post('/city/api_save_city', 'CityController@api_save_city')->name('city.save');
Route::post('/city/api_get_city', 'CityController@api_get_city')->name('city.get');
Route::post('/city/api_update_city', 'CityController@api_update_city')->name('city.update');
Route::post('/city/api_delete_city', 'CityController@api_delete_city')->name('city.delete');
Route::post('/city/api_get_province_list', 'CityController@api_get_province_list')->name('city.province');

/**
 * ProvinceOptions Routes
 */
Route::get('/province', 'ProvinceController@index')->name('province');
Route::post('/province/api_province_list', 'ProvinceController@api_province_list')->name('province.list');
Route::post('/province/api_save_province', 'ProvinceController@api_save_province')->name('province.save');
Route::post('/province/api_get_province', 'ProvinceController@api_get_province')->name('province.get');
Route::post('/province/api_update_province', 'ProvinceController@api_update_province')->name('province.update');
Route::post('/province/api_delete_province', 'ProvinceController@api_delete_province')->name('province.delete');
