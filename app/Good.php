<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function types()
    {
      return $this->belongsTo('App\Type','type_id');
    }
    public function spec()
    {
      return $this->hasOne('App\Specification');
    }
    public function receipts()
    {
      return $this->belongsToMany('App\Purchase','good_receipt','good_id','purchase_id');
    }
    public function deliveries()
    {
      return $this->belongsToMany('App\Sale','good_deliver','good_id','sale_id');
    }
    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }
    public function units()
    {
      return $this->belongsTo('App\Unit','unit_id','id');
    }
    public function catalogs()
    {
      return $this->belongsToMany('App\Catalog','catalog_good','catalog_id','good_id');
    }
    public function designers()
    {
        return $this->belongsToMany('App\Designer', 'designer_good', 'good_id', 'designer_id');
    }


    public function scopeIsProduct($query)
    {
      return $query->where('type_id','1')->limit(5);
    }
    public function scopeIsRaw($query)
    {
      return $query->where('type_id','1')->limit(5);
    }
    public function scopeSearchGood($query, $request)
    {
      return $query->where('name',$request);
    }
    public function scopeAddStock($query, $item, $qty)
    {
      return $query->find($item)->increment('qty',$qty);
    }
    public function scopeSubtractStock($query, $item, $qty)
    {
      return $query->find($item)->decrement('qty',$qty);
    }
    public function scopeSearchOrInsert($query, $request, $i, $type)
    {
      if(Good::SearchGood($request['item'.$i])->first() == null){
        $unit = Unit::SearchOrInsert($request['unit'.$i]);
        return Good::create([
          'name' => ucwords($request['item'.$i]),
          'unit_id' => $unit['id'],
          'price' => '5000',
        ]);
      }
      else {
        return Good::SearchGood($request['item'.$i])->first();
      }
    }
}
