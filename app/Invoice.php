<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['number', 'description', 'due_date', 'paid', 'client_id', 'user_id', 'template_id'];

    public function client()
    {
      return $this->belongsTo('\App\Client');
    }

    public function lineItems()
    {
      return $this->hasMany('\App\LineItem');
    }

    public function template()
    {
      return $this->hasOne('\App\Template');
    }

    public function scopeLatest($q, $client_id)
    {
      return $q->where('client_id', $client_id)->orderBy('number', 'desc');
    }
}
