<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  protected $table = "sales";
  protected $primaryKey = 'id';

  public function companies(){
     return $this->belongsTo('App\Company','company_id');
  }
  public function goods(){
     return $this->belongsToMany('App\Good','purchase_details','purchase_id','good_id')->withPivot('qty','price','subtotal');
  }
}
