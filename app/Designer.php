<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
  protected $table = 'designers';
  protected $primaryKey = 'id';
  protected $guarded = [];

  public function projects()
  {
    return $this->belongsTo('App\Project', 'project_id');
  }
}
