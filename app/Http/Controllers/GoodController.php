<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Company;
use App\Good;
use App\Warehouse;
use App\Purchase;
use App\Sale;
use App\Unit;

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
      $this->authorize('viewAny',Good::class);
      $good = Good::all();
      return view('goods.index', compact('good'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create',Good::class);
      $company = Company::all();
      $warehouse = Warehouse::all();
      return view('goods.add', compact('company', 'warehouse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create',Good::class);
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
      $this->authorize('view',$good);
      $good = Good::find($good->id);
      return view('goods.show',compact('good'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function edit(Good $good)
    {
      $this->authorize('update',$good);
      $good = Good::find($good->id);
      $unit = Unit::all();
      return view('goods.edit',compact('good', 'unit'));
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
      $this->authorize('update',$good);
      $data = $request->validate([
        'name' => 'required|max:191',
        'qty' => 'required|numeric|min:0',
        'unit' => 'required|numeric',
        'type' => 'required',
        'price' => '',
      ]);
      Good::find($good->id)->update([
          'name' => $data['name'],
          'qty' => $data['qty'],
          'unit_id' => $data['unit'],
          'type' => $data['type'],
          'price' => $data['price'],
          'updated_at' => now(),
      ]);
      return redirect(action('GoodController@show',$good->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
      $this->authorize('delete',$good);
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
    public function goodReceiptFinish(Request $request)
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
          $purchase->receipts()->attach([
            $itemData['item'.$i] => [
              'user_id' => Auth::user()->id,
              'qty' => $itemData['qty'.$i],
              'memo' => $itemData['memo'.$i],
              'created_at' => now(),
              'updated_at' => now(),
            ]
          ]);
          Good::AddStock($itemData['item'.$i], $itemData['qty'.$i]);
        }
      }
      return redirect(action('GoodController@goodReceiptPage'));
    }

    public function goodDeliverPage()
    {
      return view('goods.goodDeliver');
    }
    public function goodDeliverSearch(Request $request)
    {
      $data = $request->validate([
        'so' => 'required'
      ]);
      $sale = Sale::where('so',$data['so'])->first();
      return view('goods.goodDeliver', compact('sale'));
    }
    public function goodDeliverFinish(Request $request)
    {
      $data = $request->validate([
        'totalItem' => 'required|numeric',
        'saleID' => 'required|numeric',
      ]);
      $itemRules = [];
      for ($i=0; $i <= $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'required|numeric';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['memo'.$i] = 'nullable';
      }
      $itemData = $request->validate($itemRules);
      $sale = Sale::find($data['saleID']);
      for ($i=0; $i <= $data['totalItem'] ; $i++) {
        if ($itemData['qty'.$i] != null) {
          $sale->deliveries()->attach([
            $itemData['item'.$i] => [
              'user_id' => Auth::user()->id,
              'qty' => $itemData['qty'.$i],
              'memo' => $itemData['memo'.$i],
              'created_at' => now(),
              'updated_at' => now(),
            ]
          ]);
          Good::SubtractStock($itemData['item'.$i], $itemData['qty'.$i]);
        }
      }
      return redirect(action('GoodController@goodDeliverPage'));
    }
}
