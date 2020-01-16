<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $table = "sales";
  protected $primaryKey = 'id';
  protected $guarded = [];

  public function bills(){
     return $this->belongsTo('App\Company','billTo');
  }
  public function ships(){
     return $this->belongsTo('App\Company','shipTo');
  }
  public function goods(){
     return $this->belongsToMany('App\Good','sale_details','sale_id','good_id')->withPivot('qty','price','subtotal');
  }

  public function scopeCountSale($query)
  {
    return $query->whereRaw('SUBSTRING(created_at,1,4) = '.date('Y'))->count()+1;
  }
}
