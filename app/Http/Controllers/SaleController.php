<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Address;
use App\Sale;
use App\Company;
use App\Good;
use App\Unit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $sale = Sale::all();
      return view('sales.index',compact('sale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $company = Company::IsCustomer()->get();
      $good = Good::IsProduct()->get();
      $unit = Unit::limit(4)->get();
      return view('sales.add', compact('company', 'good', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create',Sale::class);
      $data = $request->validate([
        'company'=>'required',
        'billTo'=>'required',
        'shipTo'=>'required',
        'phone'=>'nullable',
        'reference'=>'',
        'referenceDate'=>'',
        'paymentTerms'=>'required',
        'deliveryTime'=>'required',
        'totalItem' => 'required|numeric'
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
      $billTo = Address::SearchOrInsert($data,'billTo', 'customer');
      $shipTo = Address::SearchOrInsert($data, 'shipTo', 'customer');
      $countSale = Sale::CountSale();
      $sale = Sale::create([
        'user_id' => Auth::user()->id,
        'billTo' => $billTo['id'],
        'shipTo' => $shipTo['id'],
        'so' => str_pad(date('y',time()), 3, '0').$countSale,
        'reference' => $request['reference'],
        'referenceDate' => date('Y-m-d',strtotime($request['referenceDate'])),
        'paymentTerms' => $data['paymentTerms'],
        'deliveryTime' => $data['deliveryTime'],
        'downPayment' => '0',
        'total' => '1000',
      ]);
      for ($i=0; $i < $data['totalItem']; $i++) {
        if ($itemData['item'.$i] != '') {
          $good = Good::SearchOrInsert($itemData, $i, 'Product');
          $sale->goods()->syncWithoutDetaching([
            $good['id'] => [
              'qty' => $itemData['qty'.$i],
              'price' => $itemData['price'.$i],
              'subtotal' => $itemData['subtotal'.$i],
              'memo' => '',
            ]
          ]);
        }
      }
      // return redirect(actionn('SaleController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
      $sale = Sale::find($sale->id);
      return view('sales.show',compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
      $sale = Sale::find($sale->id);
      return view('sales.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
