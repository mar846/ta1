<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Unit;

use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('viewAny', Unit::class);
      $unit = Unit::all();
      return view('units.index', compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Unit::class);
      return view('units.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Unit::class);
      $data = $request->validate([
        'name' => 'bail|required|unique:units',
      ]);
      Unit::create($data);
      return redirect(action('UnitController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
      $this->authorize('view', $unit);
      $unit = Unit::find($unit->id);
      return view('units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
      $this->authorize('update', $unit);
      $unit = Unit::find($unit->id);
      return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
      $this->authorize('update', $unit);
      $data = $request->validate([
        'name' => 'bail|required|unique:units',
      ]);
      Unit::where('id',$unit->id)->update(['name' => $data['name']]);
      return redirect(action('UnitController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
      $this->authorize('delete', $unit);
        //
    }
}
