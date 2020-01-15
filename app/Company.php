<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  protected $table = "companies";
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamps =false;

  public function goods()
  {
      return $this->belongsToMany('App\Good');
  }
  public function addresses()
  {
      return $this->hasMany('App\Address');
  }
  public function sales()
  {
     return $this->hasMany('App\Sale','sales_id');
  }
  public function purchases()
  {
     return $this->hasMany('App\Purchase','purchase_id');
  }

  public function scopeIsCustomer($query)
  {
    return $query->where('type','customer');
  }
  public function scopeSearchID($query,$name)
  {
    return $query->select('id')->where('name',$name);
  }
}
