<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  protected $table = "addresses";
  protected $primaryKey = 'id';
  protected $guarded = [];
  public $timestamps =false;

  public function companies(){
     return $this->belongsTo('App\Company', 'company_id');
  }
  public function scopeSearchAddress($query, $request)
  {
    return $query->where('address', $request);
  }
  public function scopeShipToAddress($query, $request, $company)
  {
    Address::create([
      'company_id' => $company,
      'name' => 'shipTo',
      'address' => ucwords($request['shipTo']),
      'phone' => $request['phone'],
    ]);
  }
  public function scopeSearchOrInsert($query, $request, $type, $transaction)
  {
    if(Address::SearchAddress($request[$type])->first() == null){
      if (Company::SearchID($request['company'])->first() == null){
          $company = Company::create(['name' => ucwords($request['company']),'type' => $transaction]);
          $address = Address::create([
            'company_id' => $company['id'],
            'name' => $type,
            'address' => ucwords($request[$type]),
            'phone' => $request['phone'],
          ]);
          return $address;
        }
        else {
          $company = Company::SearchID(ucwords($request['company']))->first();
          $address = Address::create([
            'company_id' => $company['id'],
            'name' => $type,
            'address' => ucwords($request[$type]),
            'phone' => $request['phone'],
          ]);
          return $address;
        }
    }
    else {
      return Address::SearchAddress($request[$type])->first();
    }
  }
}
