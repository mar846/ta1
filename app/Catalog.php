<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
  protected $table = "catalogs";
  protected $primaryKey = 'id';
  protected $guarded = [];

  public function goods()
  {
    return $this->belongsToMany('App\Good','catalog_good','good_id','catalog_id');
  }
}
