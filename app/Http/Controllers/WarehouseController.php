<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use App\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $warehouse = Warehouse::paginate(15);
      return view('warehouses.warehouse',compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Warehouse::class);
      return view('warehouses.warehouseAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Warehouse::class);
      $data = $request->validate([
        'name'=>'bail|required|unique:warehouses|max:191',
        'location'=>'bail|required|max:191',
      ]);
      Warehouse::create($data);
      return redirect(action('WarehouseController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
      $this->authorize('view', $warehouse);
      $warehouse = Warehouse::find($warehouse->id);
      return view('warehouses.warehouseShow',compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
      $this->authorize('update', $warehouse);
      $warehouse = Warehouse::find($warehouse->id);
      return view('warehouses.warehouseEdit',compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
      $this->authorize('update', $warehouse);
      $data = $request->validate([
        'name'=>'bail|required|max:191',
        'location'=>'bail|required|max:191',
      ]);
      Warehouse::find($warehouse->id)->update($data);
      return redirect(action('WarehouseController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }
}
