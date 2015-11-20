<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Lib\TemplateComposer;

class Template extends Model
{
    protected $fillable = ['body', 'thumbnail', 'user_id', 'html'];

    public function scopeAvailable($q)
    {
      $q->where('is_custom', false)->orWhere('user_id', \Auth::user()->id);
    }

    public function save(array $options = [])
    {
      $composer = new TemplateComposer($this);
      $composer->compose();
      parent::save($options);
    }
}
