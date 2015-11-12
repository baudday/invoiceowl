<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['owl_id', 'custom_id', 'description', 'due_date',
                           'paid', 'total', 'subtotal', 'client_id', 'user_id',
                           'template_id', 'published', 'pdf_path', 'sent_date'];

    public function client()
    {
      return $this->belongsTo('\App\Client');
    }

    public function lineItems()
    {
      return $this->hasMany('\App\LineItem');
    }

    public function taxItems()
    {
      return $this->hasMany('\App\TaxItem');
    }

    public function template()
    {
      return $this->belongsTo('\App\Template');
    }

    public function identifier()
    {
      return $this->custom_id ?: $this->owl_id;
    }

    public function scopeLatest($q)
    {
      return $q->orderBy('owl_id', 'desc');
    }

    public function scopePublished($q)
    {
      return $q->where('published', true);
    }

    public function scopeUnpaid($q)
    {
      return $q->where('paid', false);
    }

    public function scopePaid($q)
    {
      return $q->where('paid', true);
    }

    public function scopePastDue($q)
    {
      return $q->where('paid', false)->where('due_date', '<', new \DateTime());
    }

    public function scopeMonth($q, $field)
    {
      return $q->where(\DB::raw("MONTH($field)"), date('n'));
    }

    public function save(array $options = [])
    {
      $this->subtotal = $this->calculateSubTotal();
      $this->total = $this->calculateTotal();
      parent::save($options);
    }

    public function getSubTotal()
    {
      return $this->calculateSubTotal();
    }

    private function calculateSubTotal()
    {
      $subtotal = 0;
      foreach ($this->lineItems()->get() as $item) {
        $subtotal += $item->totalPrice();
      }
      return $subtotal;
    }

    private function calculateTotal()
    {
      $total = $this->subtotal;
      foreach ($this->taxItems()->get() as $item) {
        $total += $item->totalPrice();
      }
      return $total;
    }
}
