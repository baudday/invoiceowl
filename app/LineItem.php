<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{
    protected $fillable = ['description', 'quantity', 'unit_price'];

    public function invoice()
    {
      return $this->belongsTo('\App\Invoice');
    }

    public function totalPrice()
    {
      return $this->quantity * $this->unit_price;
    }
}
