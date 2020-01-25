<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surveyor extends Model
{
  protected $table = 'surveyors';
  protected $primaryKey = 'id';
  protected $guarded = [];
}
