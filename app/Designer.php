<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
  protected $table = 'designers';
  protected $primaryKey = 'id';
  public $timestamps = true;
  protected $guarded = [];

  public function goods()
  {
    return $this->belongsToMany('App\Good', 'designer_good', 'designer_id', 'good_id')->withPivot('qty');
  }
  public function projects()
  {
    return $this->belongsTo('App\Project', 'project_id');
  }
  public function users()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
}
