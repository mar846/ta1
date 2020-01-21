<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function receipts()
    {
      return $this->belongsToMany('App\Purchase','good_receipt','good_id','purchase_id');
    }
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
    public function scopeAddStock($query, $item, $qty)
    {
      return $query->find($item)->increment('qty',$qty);
    }
    public function scopeSearchOrInsert($query, $request, $i, $type)
    {
      if(Good::SearchGood($request['item'.$i])->first() == null){
        $unit = Unit::SearchOrInsert($request['unit'.$i]);
        return Good::create([
          'name' => $request['item'.$i],
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
