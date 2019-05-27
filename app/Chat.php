<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Chat extends Model
{
    protected $fillable = ['name'];

    public function instant_messages () {
        return $this->hasMany('App\InstantMessage');
    }

    public function users () {
    	return $this->belongsToMany('App\User')->withDefault();
    }

	public function addInstantMessage (InstantMessage $message, User $user) {
        $user->instant_messages()->save($message);
        $this->instant_messages()->save($message);
    }
}
