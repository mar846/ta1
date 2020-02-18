<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Designer;
use App\File;
use App\Good;
use App\Unit;
use App\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DesignerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('viewAny',Designer::class);
      $designer = Designer::all();
      return view('designers.index',compact('designer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create',Designer::class);
      $project = Project::all();
      $good = Good::all();
      $unit = Unit::all();
      return view('designers.add',compact('project','good','unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create',Designer::class);
      $data = $request->validate([
        'project' => 'required|numeric',
        'files' => 'file',
        'totalItem' => 'required|numeric',
      ]);
      $itemRules=[];
      for ($i=0; $i < $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
      }
      $itemData = $request->validate($itemRules);
      $designer = Designer::create([
        'project_id' => $data['project'],
        'user_id' => Auth::user()->id,
      ]);
      if ($request->hasFile('files')) {
        File::create([
          'name' => $request->file('files')->store('designers','public'),
          'type' => 'designer',
          'project_id' => $data['project'],
          'user_id' => Auth::user()->id,
        ]);
      }
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        if ($itemData['item'.$i] != '') {
          $good = Good::SearchOrInsert($itemData, $i, 'Product');
          $designer->goods()->attach([
            $good['id'] => [
              'qty' => $itemData['qty'.$i],
              'created_at' => now(),
              'updated_at' => now(),
            ]
          ]);
        }
      }
      return redirect(action('DesignerController@show',$designer));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function show(Designer $designer)
    {
      $this->authorize('view',$designer);
      $designer = Designer::find($designer->id);
      return view('designers.show',compact('designer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function edit(Designer $designer)
    {
      $this->authorize('update',$designer);
      $designer = Designer::find($designer->id);
      $good = Good::all();
      $unit = Unit::all();
      return view('designers.edit',compact('designer','good','unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designer $designer)
    {
      $this->authorize('update',$designer);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designer $designer)
    {
      $this->authorize('delete',$designer);
        //
    }
}
