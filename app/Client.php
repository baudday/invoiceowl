<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'email', 'user_id'];

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function invoices()
    {
      return $this->hasMany('App\Invoice');
    }

    public function address()
    {
      return $this->hasOne('App\Address');
    }
}
