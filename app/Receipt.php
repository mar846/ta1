<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
  protected $table = 'receipts';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamp = true;
  public function users()
  {
    return $this->belongsTo('App\User','user_id');
  }
  public function purchases()
  {
    return $this->belongsTo('App\Purchase','purchase_id');
  }
  public function goods()
  {
    return $this->belongsToMany('App\Good','good_receipt','receipt_id','good_id');
  }
}
