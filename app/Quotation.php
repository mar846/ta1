<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
  protected $table = "quotations";
  protected $primaryKey = 'id';
  public $timestamps =false;

  public function sales(){
     return $this->belongsTo('App\Sales','sale_id');
  }
  public function catalog(){
     return $this->belongsTo('App\Catalog','catalog_id');
  }
}
