<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use App\Catalog;
use App\Inverter;
use App\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $catalog = Catalog::paginate(15);
      return view('catalogs.catalog',compact('catalog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Catalog::class);
      $panel = Panel::all();
      $inverter = Inverter::all();
      return view('catalogs.catalogAdd',compact('panel', 'inverter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Catalog::class);
      $data = $request->validate([
        'name'=>'required|unique:catalogs|max:191',
        'capacity'=>'required',
        'description'=>'required|max:191',
        'panel'=>'required|numeric',
        'inverter'=>'required|numeric',
        'panelQTY'=>'required|numeric',
        'inverterQTY'=>'required|numeric',
      ]);
      $catalog = Catalog::create([
        'name' => $data['name'],
        'capacity' => $data['capacity'],
        'description' => $data['description'],
      ]);
      $catalog->panels()->sync([
        $data['panel'] => [
          'qty' => $data['panelQTY'],
        ]
      ]);
      $catalog->inverters()->sync([
        $data['inverter'] => [
          'qty' => $data['inverterQTY'],
        ]
      ]);
      return redirect(action('CatalogController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
      $this->authorize('view', $catalog);
      $catalog = Catalog::find($catalog->id);
      return view('catalogs.catalogShow',compact('catalog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalog $catalog)
    {
      $this->authorize('update', $catalog);
      $catalog = Catalog::find($catalog->id);
      $panel = Panel::all();
      $inverter = Inverter::all();
      return view('catalogs.catalogEdit',compact('catalog', 'panel', 'inverter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalog $catalog)
    {
      $this->authorize('update', $catalog);
      $data = $request->validate([
        'name'=>'required|max:191',
        'capacity'=>'required',
        'description'=>'max:191',
        'panel'=>'required|numeric',
        'inverter'=>'required|numeric',
        'panelQTY'=>'required|numeric',
        'inverterQTY'=>'required|numeric',
      ]);
      Catalog::find($catalog->id)->update([
        'name' => $data['name'],
        'capacity' => $data['capacity'],
        'description' => $data['description'],
      ]);
      $catalog = Catalog::find($catalog->id);
      $catalog->panels()->sync([
        $data['panel'] => [
          'qty' => $data['panelQTY'],
        ]
      ]);
      $catalog->inverters()->sync([
        $data['inverter'] => [
          'qty' => $data['inverterQTY'],
        ]
      ]);
      return redirect(action('CatalogController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {
        //
    }
}
