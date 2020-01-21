<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use App\Company;
use App\Good;
use App\Warehouse;
use App\Purchase;
use Auth;

use Illuminate\Http\Request;

class GoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $good = Good::all();
      return view('goods.good', compact('good'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $company = Company::all();
      $warehouse = Warehouse::all();
      return view('goods.goodAdd', compact('company', 'warehouse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = $request->validate([
        'name'=>'required|unique:goods',
        'description'=>'string',
        'qty' => 'numeric|min:0',
        'company'=>'required|numeric',
        'warehouse'=>'required|numeric',
      ]);
      Good::create($validator);
      return redirect(action('GoodController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function edit(Good $good)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Good $good)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
        //
    }

    public function goodReceiptPage()
    {
      return view('goods.goodReceipt');
    }
    public function goodReceiptSearch(Request $request)
    {
      $data = $request->validate([
        'po'=>'required',
      ]);
      $purchase = Purchase::where('po', $data['po'])->firstOrFail();
      return view('goods.goodReceipt', compact('purchase'));
    }
    public function goodReceiptFinish(Request $request, Good $good)
    {
      $data = $request->validate([
        'totalItem' => 'required|numeric|min:0',
        'purchaseID' => 'required|numeric',
      ]);
      $itemRules = [];
      for ($i=0; $i <= $data['totalItem'] ; $i++) {
        $itemRules['item'.$i] = 'required|numeric';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['memo'.$i] = 'nullable';
      }
      $itemData = $request->validate($itemRules);
      $purchase = Purchase::find($data['purchaseID']);
      for ($i=0; $i <= $data['totalItem']; $i++) {
        if ($itemData['qty'.$i] !== null) {
          $purchase->receipts()->syncWithoutDetaching([
            $itemData['item'.$i] => [
              'user_id' => Auth::user()->id,
              'qty' => $itemData['qty'.$i],
              'memo' => $itemData['memo'.$i],
              'created_at' => now(),
              'updated_at' => now(),
            ]
          ]);
            DB::enableQueryLog();
          Good::where('id',$itemData['item'.$i])->increment('qty',$itemData['qty'.$i]);
          dd(DB::getQueryLog());
        }
      }
      echo "string";
    }
}
