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
use App\Specification;
use App\Type;
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
      $type = Type::all();
      $unit = Unit::all();
      return view('goods.add', compact('company', 'warehouse','type','unit'));
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
      $data = $request->validate([
        'name'=>'required|unique:goods',
        'unit'=>'required|numeric',
        'type'=>'required|numeric',
        'price'=>'required|numeric',
        'description'=>'',
        'supplier'=>'required|numeric',
        'current' => 'nullable',
        'capacity' => 'nullable|numeric|min:1',
        'minVolt' => 'nullable|numeric',
        'maxVolt' => 'nullable|numeric|min:1',
        'efficiency' => 'nullable|numeric|min:1|max:100',
        'safetyMargin' => 'nullable|numeric|min:1|max:100',
      ]);
      $good = Good::create([
        'name' => $data['name'],
        'unit_id' => $data['unit'],
        'price' => $data['price'],
        'capacity' => $data['capacity'],
        'company_id' => $data['supplier'],
        'description' => $data['description'],
        'type_id' => $data['type'],
      ]);
      if ($data['type'] == '1' || $data['type'] == '2') {
        if ($data['maxVolt'] != null || $data['efficiency'] != null || $data['capacity'] != null) {
          Specification::create([
            'capacity' => $data['capacity'],
            'maxCurrent' => $data['current'],
            'maxVolt' => $data['maxVolt'],
            'minVolt' => $data['minVolt'],
            'efficiency' => $data['efficiency'],
            'safetyMargin' => $data['safetyMargin'],
            'good_id' => $good->id
          ]);
        }
      }
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
      $good = Good::with(['companies','units','types','spec'])->find($good->id);
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
      $good = Good::with(['companies','units','types','spec'])->find($good->id);
      $unit = Unit::all();
      $company = Company::all();
      $type = Type::all();
      return view('goods.edit',compact('good', 'unit','type','company'));
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
        'unit' => 'required|numeric',
        'type' => 'required',
        'price' => '',
        'description' => '',
        'supplier' => 'required|numeric',
        'capacity' => 'nullable|numeric|min:1',
        'current' => 'nullable',
        'minVolt' => 'nullable|numeric',
        'maxVolt' => 'nullable|numeric|min:1',
        'efficiency' => 'nullable|numeric|min:1|max:100',
        'safetyMargin' => 'nullable|numeric|min:1|max:100',
      ]);
      if ($data['type'] == 'Panel' || $data['type'] == 'Inverter') {
        Good::find($good->id)->update([
            'name' => $data['name'],
            'unit_id' => $data['unit'],
            'type_id' => $data['type'],
            'price' => $data['price'],
            'capacity' => $data['capacity'],
            'company_id' => $data['supplier'],
            'updated_at' => now(),
        ]);
        if ($data['maxVolt'] != null || $data['efficiency'] != null || $data['capacity'] != null) {
          Specification::where('good_id',$good['id'])->update([
            'capacity' => $data['capacity'],
            'current' => $data['current'],
            'maxVolt' => $data['maxVolt'],
            'minVolt' => $data['minVolt'],
            'efficiency' => $data['efficiency'],
            'safetyMargin' => $data['safetyMargin'],
            'good_id' => $good->id
          ]);
        }
      }
      else {
        Good::find($good->id)->update([
            'name' => $data['name'],
            'unit_id' => $data['unit'],
            'type_id' => $data['type'],
            'price' => $data['price'],
            'company_id' => $data['supplier'],
            'updated_at' => now(),
        ]);
      }
      return redirect(action('GoodController@index'));
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
