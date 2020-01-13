<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $table = "sales";
  protected $primaryKey = 'id';
  protected $guarded = [];

  public function companies(){
     return $this->belongsTo('App\Company','company_id');
  }
  public function goods(){
     return $this->belongsToMany('App\Good','sale_details','sale_id','good_id')->withPivot('qty','price','subtotal');
  }
}
