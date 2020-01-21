<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  protected $table = "purchases";
  protected $primaryKey = 'id';
  protected $guarded = [];
  public function addresses(){
     return $this->belongsTo('App\Address','address_id');
  }
  public function goods(){
     return $this->belongsToMany('App\Good','purchase_details','purchase_id','good_id')->withPivot('qty','price','subtotal');
  }
  public function receipts()
  {
    return $this->belongsToMany('App\Good','good_receipt','purchase_id','good_id');
  }
  public function scopeCountPurchase($query)
  {
    return $query->whereRaw('SUBSTRING(created_at,1,4) = '.date('Y'))->count()+1;
  }
}
