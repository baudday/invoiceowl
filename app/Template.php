<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['body', 'thumbnail', 'user_id'];

    public function scopeAvailable($q)
    {
      $q->where('is_custom', false)->orWhere('user_id', \Auth::user()->id);
    }
}
