<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Designer;
use App\Project;
use App\File;

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
      $project = Project::all();
      return view('designers.add',compact('project'));
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
        'project' => 'required|numeric',
        'files' => 'file',
      ]);
      $designer = Designer::create([
        'project_id' => $data['project'],
        'user_id' => Auth::user()->id,
      ]);
      if ($request->hasFile('files')) {
        File::create([
          'name' => $request->file('files')->store('uploads','public'),
          'type' => 'designer',
          'project_id' => $data['project'],
          'user_id' => Auth::user()->id,
        ]);
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
        //
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
        //
    }
}
