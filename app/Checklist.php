<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
  protected $table = 'checklists';
  protected $primaryKey = 'id';
  protected $guarded = [];
  public function surveyors()
  {
      return $this->belongsToMany('App\Surveyor','checklist_surveyor','checklist_id','surveyor_id')->withPivot('answer');
  }
}
