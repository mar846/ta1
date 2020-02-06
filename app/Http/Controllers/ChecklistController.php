<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Checklist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $checklist = Checklist::all();
      return view('checklists.index', compact('checklist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('checklists.add');
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
        'question' => 'bail|required|unique:checklists',
      ]);
      Checklist::create([
        'user_id' => Auth::user()->id,
        'question' => $data['question'],
      ]);
      return redirect(action('ChecklistController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function show(Checklist $checklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklist $checklist)
    {
      $checklist = Checklist::find($checklist->id);
      return view('Checklists.edit', compact('checklist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $checklist)
    {
      $data = $request->validate([
        'question' => 'bail|required|unique:checklists',
      ]);
      Checklist::where('id',$checklist->id)->update([
        'question' => $data['question'],
      ]);
      return redirect(action('ChecklistController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist)
    {
        //
    }
}
