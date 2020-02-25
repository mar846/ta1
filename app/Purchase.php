<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  protected $table = "purchases";
  protected $primaryKey = 'id';
  protected $guarded = [];
  public function projects(){
     return $this->belongsTo('App\Project','project_id');
  }
  public function users(){
   return $this->belongsTo('App\User','user_id');
  }
  public function addresses(){
     return $this->belongsTo('App\Address','address_id');
  }
  public function goods(){
     return $this->belongsToMany('App\Good','purchase_details','purchase_id','good_id')->withPivot('qty','price','subtotal');
  }
  public function receipts()
  {
    return $this->hasMany('App\Receipt');
  }
  public function scopeCountPurchase($query)
  {
    return $query->whereRaw('SUBSTRING(created_at,1,4) = '.date('Y'))->count()+1;
  }
}
