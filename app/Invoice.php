<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['number', 'description', 'due_date', 'paid', 'total', 'client_id', 'user_id', 'template_id', 'published', 'pdf_path', 'sent_date'];

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
      return $this->belongsTo('\App\Template');
    }

    public function scopeLatest($q)
    {
      return $q->orderBy('number', 'desc');
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
      $this->total = $this->calculateTotal();
      parent::save($options);
    }

    private function calculateTotal()
    {
      $total = 0;
      foreach ($this->lineItems()->get() as $item) {
        $total += $item->totalPrice();
      }
      return $total;
    }
}
