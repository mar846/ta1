<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }
    public function units()
    {
      return $this->belongsTo('App\Unit','unit_id','id');
    }
    public function bills()
    {
        return $this->belongsToMany('App\BillOfMaterial', 'bill_of_materials_goods', 'good_id', 'bill_id');
    }
    public function scopeIsProduct($query)
    {
      return $query->where('type','Product')->limit(5);
    }
    public function scopeIsRaw($query)
    {
      return $query->where('type','Raw')->limit(5);
    }
    public function scopeSearchGood($query, $request)
    {
      return $query->where('name',$request);
    }
    public function scopeSearchOrInsert($query, $request, $i, $type)
    {
      if(Good::SearchGood($request['item'.$i])->first() == null){
        $unit = (Unit::SearchOrInsert($request['unit'.$i])->first() == null) ? Unit::create(['name' => strtolower($request['unit'.$i])]) : Unit::SearchOrInsert($request['unit'.$i])->first();
        return Good::create([
          'name' => $request['item'.$i],
          'qty' => $request['qty'.$i],
          'unit_id' => $unit['id'],
          'price' => '5000',
          'type' => $type,
        ]);
      }
      else {
        return Good::SearchGood($request['item'.$i])->first();
      }
    }
}
