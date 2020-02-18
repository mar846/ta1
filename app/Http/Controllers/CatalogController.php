<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Catalog;
use App\Good;
use App\Unit;

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
      $good = Good::with('units')->get();
      $unit = Unit::all();
      return view('catalogs.add', compact('good','unit'));
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
        'name'=>'required|max:191',
        'capacity'=>'required',
        'description'=>'max:191',
        'totalItem' => 'required|numeric',
      ]);
      $itemRules=[];
      for ($i=0; $i < $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
      }
      $itemData = $request->validate($itemRules);
      $catalog = Catalog::create([
        'name' => $data['name'],
        'capacity' => $data['capacity'],
        'description' => $data['description'],
        'user_id' => Auth::user()->id,
      ]);
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        if ($itemData['item'.$i] != '') {
          $good = Good::SearchOrInsert($itemData, $i, 'Product');
          $catalog->goods()->attach([
            $good['id'] => [
              'qty' => $itemData['qty'.$i],
              'description' => '',
              'created_at' => now(),
              'updated_at' => now(),
            ]
          ]);
        }
      }
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
        'totalItem' => 'required|numeric',
      ]);
      $itemRules=[];
      for ($i=0; $i < $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
      }
      $itemData = $request->validate($itemRules);
      Catalog::find($catalog->id)->update([
        'name' => $data['name'],
        'capacity' => $data['capacity'],
        'description' => $data['description'],
      ]);
      for ($i=0; $i < $data['totalItem']; $i++) {
        $good = Good::SearchOrInsert($itemData,$i,'Product');
        $catalog->goods()->syncWithoutDetaching([
          $good['id'] => [
            'qty' => $itemData['qty'.$i],
            'description' => '',
            'updated_at' => now(),
          ]
        ]);
      }
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
