<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    if ($user->id === $id) {
    	return true;
    } else {
    	return false;
    }
});

Broadcast::channel('Presence', function ($user) {
	return [
		'id' => $user->id,
		'name' => $user->name,
		'email' => $user->email
	];
});

Broadcast::channel('public-channel', function ($user) {

});