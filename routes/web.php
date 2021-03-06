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
	$messages = App\PublicInstantMessage::with('user')->get();
	return view('public-channel', compact('messages'));
})->name('public-channel');

Route::get('/presence-channel', function () {
	$messages = App\PresenceMessage::with('user')->get();
	return view('presence-channel', compact('messages'));
})->name('presence-channel')->middleware('auth');

Route::get('/chatrooms', function () {
	$rooms = App\Chat::get();
	return view('chat-room-index', compact('rooms'));
})->name('chatrooms');

Route::get('/chatrooms/{id}', function ($id) {
	// Fetch the messages, along with their senders, from the chatroom
	$chat = App\Chat::with(['instant_messages.user', 'users'])->findOrFail($id); 
	$imessages = $chat->instant_messages;
	$user = auth()->user();

	if (!$chat->users->contains('id', $user->id)) { // Check if auth'ed user is in the participants array, if not add them.
		$chat->users()->save($user);
	}

	$participants = $chat->users;
	
	return view('private-channel', compact('imessages', 'user', 'id', 'participants'));

})->middleware('auth')->name('private-channel');

Route::post('/message', function () {
	$message = new App\PublicInstantMessage();
	$message->body = request('message');

	if (request('user')) {
		$user = auth()->user();
		$user->public_messages()->save($message);
		broadcast(new App\Events\NewPublicMessage($message));
	} else {
		$message->save();
		broadcast(new App\Events\NewPublicMessage($message));
	}
});

Route::post('message/private', function () {
	$user = auth()->user();

	$imessage = new App\InstantMessage();
	$imessage->body = request('message');

	$chat = App\Chat::first();
	$user->addInstantMessage($imessage, $chat);
	broadcast(new App\Events\NewPrivateMessage( request('message'), request('roomId'), $user));
})->middleware('auth');

Route::post('message/presence', function () {
	$user = auth()->user();

	$message = new App\PresenceMessage();
	$message->body = request('message');

	$user->presence_messages()->save($message);
	broadcast(new App\Events\NewPresenceMessage($message->load('user')));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
