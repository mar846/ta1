<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
  protected $table = 'terms';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamp = TRUE;
  public function sales()
  {
    return $this->belongsTo('App\Sale','sales_id');
  }
}
