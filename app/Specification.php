<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
  protected $table = 'specifications';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public function good()
  {
    return $this->hasOne('App\Good','good_id');
  }
}
