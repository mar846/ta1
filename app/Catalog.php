<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
  protected $table = "catalogs";
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamps =false;

  
}
