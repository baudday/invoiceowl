<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'client_id', 'line_one', 'line_two', 'city', 'state', 'zip', 'country'];

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function client()
    {
      return $this->belongsTo('App\Client');
    }
}
