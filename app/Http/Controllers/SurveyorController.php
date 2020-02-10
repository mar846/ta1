<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Validator;

use App\Checklist;
use App\Project;
use App\Surveyor;
use App\File;

use Illuminate\Http\Request;

class SurveyorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $surveyor = Surveyor::all();
      return view('surveyors.index',compact('surveyor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $project = Project::all();
      $checklist = Checklist::all();
      return view('surveyors.add', compact('project', 'checklist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $checklistTotal = Checklist::count();
      $data = $request->validate([
        'project' => 'required',
        'file' => 'nullable|file|image|max:2000',
      ]);
      $itemRules=[];
      for ($i=0; $i < Checklist::count(); $i++) {
        $itemRules['answer'.$i] = '';
      }
      $itemData = $request->validate($itemRules);
      $surveyor = Surveyor::create([
        'project_id' => $data['project'],
        'user_id' => Auth::user()->id,
      ]);
      if ($request->hasFile('file')) {
        File::create([
          'name' => $request->file('file')->store('uploads','public'),
          'type' => 'surveyor',
          'project_id' => $data['project'],
          'user_id' => Auth::user()->id,
        ]);
      }
      for ($i=0; $i < Checklist::count(); $i++) {
        $surveyor->checklists()->attach([
          $i+1 => [
            'answer' => $itemData['answer'.$i],
            'created_at' => now(),
            'updated_at' => now(),
          ]
        ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Surveyor  $surveyor
     * @return \Illuminate\Http\Response
     */
    public function show(Surveyor $surveyor)
    {
      $surveyor = Surveyor::find($surveyor->id);
      return view('surveyors.show', compact('surveyor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Surveyor  $surveyor
     * @return \Illuminate\Http\Response
     */
    public function edit(Surveyor $surveyor)
    {
      $project = Project::all();
      $checklist = Checklist::all();
      $surveyor = Surveyor::find($surveyor->id);
      return view('surveyors.edit', compact('project', 'checklist', 'surveyor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Surveyor  $surveyor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Surveyor $surveyor)
    {
      $checklistTotal = Checklist::count();
      $data = $request->validate(['project' => 'required']);
      $itemRules=[];
      for ($i=0; $i < Checklist::count(); $i++) {
        $itemRules['answer'.$i] = '';
      }
      $itemData = $request->validate($itemRules);
      Surveyor::find($surveyor->id)->update([
        'project_id' => $data['project'],
      ]);
      for ($i=0; $i < Checklist::count(); $i++) {
        $surveyor->checklists()->syncWithoutDetaching([
          $i+1 => [
            'answer' => $itemData['answer'.$i],
            'updated_at' => now(),
          ]
        ]);
      }
      return redirect(action('SurveyorController@show',$surveyor->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Surveyor  $surveyor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surveyor $surveyor)
    {
        //
    }
}
