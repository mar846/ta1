<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  protected $table = 'invoices';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamp = true;
  public function users()
  {
    return $this->belongsTo('App\User','user_id');
  }
  public function sales()
  {
    return $this->belongsTo('App\Sale','sale_id');
  }
}
