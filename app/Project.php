<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "projects";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $guarded = [];
    public function companies(){
       return $this->belongsTo('App\Company','company_id');
    }
    public function files(){
       return $this->hasMany('App\File');
    }
}
