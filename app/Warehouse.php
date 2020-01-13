<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
  protected $table = "warehouses";
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamps =false;

  public function panels(){
     return $this->belongsToMany(Panel::class,'panel_warehouse')->withPivot('qty');
  }
  public function inverters(){
     return $this->belongsToMany(Inverter::class,'inverter_warehouse')->withPivot('qty');
  }
}
