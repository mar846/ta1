<?php

namespace App\Http\Controllers;
use DB;
use Validator;

use App\BillOfMaterial;
use App\Good;
use App\Unit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillOfMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bill = BillOfMaterial::all();
        return view('bills.bill', compact('bill'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $product = Good::IsProduct()->get();
      $raw = Good::IsRaw()->get();
      $unit = Unit::limit(4)->get();
      return view('bills.billAdd', compact('raw', 'product', 'unit'));
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
        'name' => 'required',
        'qty' => 'required|numeric|min:1',
        'unit' => 'required',
        'description' => '',
        'totalItem' => 'required|numeric',
      ]);
      $itemRules = [];
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
        $itemRules['description'.$i] = 'nullable';
      }
      $itemData = $request->validate($itemRules);
      $unit = Unit::SearchOrInsert($data['unit'])->first();
      $bill = BillOfMaterial::create([
        'name' => $data['name'],
        'qty' => $data['qty'],
        'unit_id' => $unit['id'],
      ]);
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        if ($itemData['item'.$i] != '') {
          $good = Good::SearchOrInsert($itemData, $i, 'Raw');
          $bill->goods()->syncWithoutDetaching([
            $good['id'] => [
              'qty' => $itemData['qty'.$i],
              'unit_id' => $good['unit_id'],
              'description' => $itemData['description'.$i],
              'memo' => '',
            ]
          ]);
        }
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillOfMaterial $billOfMaterial)
    {
        //
    }
}
