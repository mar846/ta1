<?php

namespace App\Http\Controllers;

use DB;
use Validation;
use Auth;

use App\Address;
use App\Company;
use App\Project;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $project = Project::all();
      return view('projects.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('projects.add');
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
          'location' => 'required',
          'description' => 'max:191',
          'company' => 'required',
          'address' => 'required',
          'phone' => '',
        ]);
        $company = Address::SearchOrInsert($data, 'address', 'customer');
        Project::create([
          'name' => $data['name'],
          'location' => $data['location'],
          'description' => $data['description'],
          'company_id' => $company->id,
          'user_id' => Auth::user()->id,
        ]);
        return redirect(action('ProjectController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
      $project = Project::find($project->id);
      return view('projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
      $project = Project::find($project->id);
      return view('projects.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
      $data = $request->validate([
        'name' => 'required',
        'location' => 'required',
        'description' => 'max:191',
        'customer' => 'required',
      ]);
      $project = Project::find($project->id);
      Company::find($project->company_id)->update([
        'name' => $data['customer'],
      ]);
      Project::find($project->id)->update([
        'name' => $data['name'],
        'location' => $data['location'],
        'description' => $data['description'],
      ]);
      return redirect(action('ProjectController@show',$project->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
