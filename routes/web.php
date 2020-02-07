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

//Route::get('getcities', 'Zomato\ZomatoController@getCities');
//Route::get('getcuisines', 'Zomato\ZomatoController@getCuisines');
//Route::get('getallcitiescafes', 'Zomato\ZomatoController@getAllCitiesCafes');
//Route::get('importallpresscafes', 'Allpress\AllpressController@importCafes');
//Route::get('importsupremecafes', 'Supreme\SupremeController@importCafes');
Route::get('test', 'HomeController@getClosestCafesByIp');

Route::get('/{any}', function () {

    $home = new \App\Http\Controllers\HomeController();
    $cafes = $home->getClosestCafesByIp();

    return view('welcome', compact('cafes'));
})->where('any', '.*');
