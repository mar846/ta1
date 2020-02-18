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
    return $this->belongsToMany('App\Good','catalog_good','catalog_id','good_id')->withPivot('qty','description');
  }
  public function users()
  {
    return $this->belongsTo('App\User','user_id');
  }
}
