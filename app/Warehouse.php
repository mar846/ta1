<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
  protected $table = "warehouses";
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamps =false;
}
