<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliver extends Model
{
  protected $table = 'delivers';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public function sales()
  {
    return $this->belongsTo('App\Sale','sale_id');
  }
  public function users()
  {
    return $this->belongsTo('App\User','user_id');
  }
  public function goods()
  {
    return $this->belongsToMany('App\Good','deliver_good','deliver_id','good_id')->withPivot('qty')->withTimestamps();
  }
}
