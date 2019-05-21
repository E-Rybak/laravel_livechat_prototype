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
})->name('home');

Route::get('/public-channel', function () {
	return view('public-channel');
})->name('public-channel');

Route::get('/presence-channel', function () {
	return 'Not yet implemented';
})->name('presence-channel');

Route::get('/private-channel', function () {
	return 'Not yet implemented';
})->name('private-channel');

Route::post('/SendNewMessage', function () {
	broadcast(new App\Events\NewPublicMessage( request('message'), request('user') ))->toOthers();
});