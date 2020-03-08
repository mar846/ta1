<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $table = "sales";
  protected $primaryKey = 'id';
  protected $guarded = [];

  public function projects(){
     return $this->belongsTo('App\Project','project_id');
  }
  public function users(){
   return $this->belongsTo('App\User','user_id');
  }
  public function supervisors(){
   return $this->belongsTo('App\User','supervisor_id');
  }
  public function bills(){
     return $this->belongsTo('App\Address','billTo');
  }
  public function ships(){
     return $this->belongsTo('App\Address','shipTo');
  }
  public function invoices(){
     return $this->hasMany('App\Invoice');
  }
  public function delivers()
  {
    return $this->hasMany('App\Deliver');
  }
  public function terms()
  {
    return $this->hasMany('App\Term');
  }
  public function goods(){
     return $this->belongsToMany('App\Good','sale_details','sale_id','good_id')->withPivot('qty','price','subtotal');
  }

  public function scopeCountSale($query)
  {
    return $query->whereRaw('SUBSTRING(created_at,1,4) = '.date('Y'))->count()+1;
  }
}
