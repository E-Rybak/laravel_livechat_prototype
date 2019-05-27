<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstantMessage extends Model
{
    //
    protected $fillable = ['body', 'user_id', 'chat_id'];

    public function user () {
    	return $this->belongsTo('App\User');
    }
}
