<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use App\Catalog;

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
      $catalog = Catalog::all();
      return view('catalogs.index',compact('catalog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Catalog::class);
      return view('catalogs.add');
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
      return view('catalogs.show',compact('catalog'));
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
      return view('catalogs.edit',compact('catalog'));
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
      ]);
      Catalog::find($catalog->id)->update([
        'name' => $data['name'],
        'capacity' => $data['capacity'],
        'description' => $data['description'],
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
