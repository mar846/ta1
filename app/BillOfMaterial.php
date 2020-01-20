<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    protected $table = 'bill_of_materials';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function goods()
    {
        return $this->belongsToMany('App\Good', 'bill_of_materials_goods', 'bill_id', 'good_id');
    }
    public function units()
    {
        return $this->belongsTo('App\Unit', 'unit_id');
    }
}
