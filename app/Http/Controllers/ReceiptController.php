<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Good;
use App\Purchase;
use App\Receipt;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $receipt = Receipt::all();
      $purchase = Purchase::all();
      return view('receipts.index',compact('purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request)
     {
       $data = $request->validate([
         'id' => 'required|numeric',
       ],[
         'id.numeric' => 'You have to choose purchase',
       ]);
       $purchase = Purchase::find($data['id']);
       return view('receipts.add',compact('purchase'));
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'purchase' => 'required|numeric|min:1'
      ],[
        'purchase.numeric' => 'You have to choose purchase',
      ]);
      $purchase = Purchase::find($data['purchase']);
      $goodCount = count($purchase->goods);
      $itemRules = [];
      for ($i=0; $i < $goodCount; $i++) {
        $itemRules['qty'.$i] = "nullable|numeric|min:1";
      }
      $good = [];
      foreach ($purchase->goods as $key => $value) {
        $good[] = $value['id'];
      }
      $itemData = $request->validate($itemRules);
      $receipt = Receipt::create([
        'purchase_id' => $purchase->id,
        'user_id' => Auth::user()->id,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
      for ($i=0; $i < $goodCount; $i++) {
        if (isset($itemData['qty'.$i])) {
          if ($itemData['qty'.$i] != null) {
            $receipt->goods()->attach([
              $good[$i] => [
                'qty' => $itemData['qty'.$i],
                'created_at' => now(),
                'updated_at' => now(),
              ]
            ]);
            Good::find($good[$i])->increment('qty', $itemData['qty'.$i]);
          }
        }
      }
      return redirect(action('ReceiptController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
