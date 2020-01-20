<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use App\Address;
use App\Purchase;
use App\Company;
use App\Good;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $purchase = Purchase::paginate(25);
      return view('purchases.purchase',compact('purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create',Purchase::class);
      $company = Company::IsSupplier()->get();
      $good = Good::IsRaw()->get();
      $unit = Unit::limit(3)->get();
      return view('purchases.purchaseAdd',compact('company', 'good', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create',Purchase::class);
      $data = $request->validate([
        'company' => 'required',
        'address' => 'required',
        'phone' => '',
        'reference' => '',
        'referenceDate' => '',
        'totalItem' => 'bail|required|numeric|min:1',
      ]);
      $itemRules=[];
      for ($i=0; $i < $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
        $itemRules['price'.$i] = 'nullable|numeric|min:1';
        $itemRules['subtotal'.$i] = 'nullable|numeric|min:1';
      }
      $itemData = $request->validate($itemRules);
      $supplier = Address::SearchOrInsert($data, 'address', 'supplier');
      $countPurchase = Purchase::CountPurchase();
      $purchase = Purchase::create([
        'address_id' => $supplier['id'],
        'po' => $countPurchase.date('Ymd',time()),
        'reference' => $data['reference'],
        'referenceDate' => date('Y-m-d', strtotime($data['referenceDate'])),
        'total' => '7750000',
      ]);
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        if ($itemData['item'.$i] != '') {
          $good = Good::SearchOrInsert($itemData, $i, 'Raw');
          $purchase->goods()->syncWithoutDetaching([
            $good['id'] => [
              'qty' => $itemData['qty'.$i],
              'price' => $itemData['price'.$i],
              'subtotal' => $itemData['subtotal'.$i],
              'memo' => '',
            ]
          ]);
          $good->companies()->syncWithoutDetaching($supplier['id']);
        }
      }
      return redirect(action('PurchaseController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
      $this->authorize('view',$purchase);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
      $this->authorize('update',$purchase);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
      $this->authorize('update',$purchase);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
