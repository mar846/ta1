<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }
}
