<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
  protected $table = 'types';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public function goods()
  {
    return $this->hasMany('App\Good');
  }
}
