<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
  protected $table = 'criterias';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamps = false;

}
