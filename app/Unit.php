<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
  protected $table = 'units';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamps = false;

  public function bills()
  {
    return $this->hasMany('App\BillOfMaterial');
  }
  public function goods()
  {
    return $this->hasMany('App\Good');
  }

  public function scopeSearchOrInsert($query, $request)
  {
    return (Unit::where('name',$request)->first() == null) ? Unit::create(['name'=>strtolower($request)]) : Unit::where('name',$request)->first();
  }
}
