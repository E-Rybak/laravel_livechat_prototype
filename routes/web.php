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
})->name('base');

Route::get('/public-channel', function () {
	return view('public-channel');
})->name('public-channel');

Route::get('/presence-channel', function () {
	return 'Not yet implemented';
})->name('presence-channel');

Route::get('/chatrooms', function () {
	$rooms = App\Chat::get();
	return view('chat-room-index', compact('rooms'));
})->name('chatrooms');

Route::get('/chatrooms/{id}', function ($id) {
	// Fetch the messages, along with their senders, from the chatroom
	$imessages = App\Chat::with('instant_messages.user')->findOrFail($id)->instant_messages; 

	$user = auth()->user();

	return view('private-channel', compact('imessages', 'user', 'id'));

})->middleware('auth')->name('private-channel');

Route::post('/SendNewMessage', function () {
	broadcast(new App\Events\NewPublicMessage( request('message'), request('user')));
});

Route::post('message/private', function () {
	$user = auth()->user();

	$imessage = new App\InstantMessage();
	$imessage->body = request('message');

	$chat = App\Chat::first();
	$user->addInstantMessage($imessage, $chat);
	broadcast(new App\Events\NewPrivateMessage( request('message'), request('roomId'), $user));
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
