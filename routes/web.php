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
use Illuminate\Support\Facades\Broadcast;
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/public-channel', function () {
	return view('public-channel');
})->name('public-channel');

Route::get('/presence-channel', function () {
	return 'Not yet implemented';
})->name('presence-channel');

Route::get('/private-channel', function () {
	return view('private-channel');
})->name('private-channel');

Route::post('/SendNewMessage', function () {
	broadcast(new App\Events\NewPublicMessage( request('message'), request('user') ));
});

Route::post('message/private', function () {
	broadcast(new App\Events\NewPrivateMessage( request('message'), request('user') ));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
