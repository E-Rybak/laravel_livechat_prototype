<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\InstantMessage;
use App\Chat;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function instant_messages () {
        return $this->hasMany('App\InstantMessage');
    }

    public function chats () {
        return $this->belongsToMany('App\Chat');
    }

    public function public_messages () {
        return $this->hasMany('App\PublicInstantMessage');
    }

    public function presence_messages () {
        return $this->hasMany('App\PresenceMessage');
    }

    public function addInstantMessage (InstantMessage $message, Chat $chat) {
        $chat->instant_messages()->save($message);
        $this->instant_messages()->save($message);
    }
}
