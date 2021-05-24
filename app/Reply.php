<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    //
    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function likedUsers(){
        return $this->belongsToMany(User::class, 'likes');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
