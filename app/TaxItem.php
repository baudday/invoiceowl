<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxItem extends Model
{
    protected $fillable = ['description', 'percentage', 'invoice_id'];

    public function invoice()
    {
      return $this->belongsTo('\App\Invoice');
    }

    public function totalPrice()
    {
      return ($this->percentage / 100) * $this->invoice->subtotal;
    }
}
