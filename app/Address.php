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
  public function scopeSearchOrInsert($query, $request, $type, $transaction)
  {
    if(Address::SearchAddress($request[$type])->first() == null){
      if (Company::SearchID($request['company'])->first() == null){
          $customer = Company::create(['name' => ucwords($request['company']),'type' => $transaction]);
          Address::create([
            'company_id' => $customer['id'],
            'name' => 'primary',
            'address' => ucwords($request[$type]),
            'phone' => $request['phone'],
          ]);
          return $customer;
        }
        else {
          $customer = Company::SearchID(ucwords($request['company']))->first();
          Address::create([
            'company_id' => $customer['id'],
            'name' => 'primary',
            'address' => ucwords(strtolower($request[$type])),
            'phone' => $request['phone'],
          ]);
          return $customer;
        }
    }
    else {
      return Address::SearchAddress($request[$type])->first();
    }
  }
}
