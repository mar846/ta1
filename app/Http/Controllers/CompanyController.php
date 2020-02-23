<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use App\Address;
use App\Company;
use App\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('viewAny', Company::class);
      $company = Company::all();
      return view('companies.index',compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Company::class);
      return view('companies.add');
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
        'name'=>'required|max:191',
        'type'=>'required',
        'addressName0'=>'required',
        'address0'=>'required',
        'phone0'=>'nullable',
      ]);
      if($data['type'] == 'customer'){
        $dataRules = [
          'addressName1'=>'required',
          'address1'=>'required',
          'phone1'=>'nullable',
        ];
        $data = $request->validate($dataRules);
      }
      $company = Company::create([
        'name' => $data['name'],
        'type' => $data['type'],
      ]);
      $max = ($data['type'] == 'supplier')?1:2;
      for ($i=0; $i < $max; $i++) {
        Address::create([
          'company_id' => $company->id,
          'name' => $data['addressName'.$i],
          'address' => $data['address'.$i],
          'phone' => $data['phone'.$i],
        ]);
      }
      return redirect(action('CompanyController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
      $this->authorize('view', $company);
      $company = Company::find($company->id);
      return view('companies.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
      $this->authorize('update', $company);
      $company = Company::find($company->id);
      return view('companies.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
      $this->authorize('update', $company);
      $data = $request->validate([
        'name'=>'required|max:191',
        'type'=>'required',
        'id0'=>'required|numeric',
        'addressName0'=>'required',
        'address0'=>'required',
        'phone0'=>'nullable',
        'id1'=>'required|numeric',
        'addressName1'=>'required',
        'address1'=>'required',
        'phone1'=>'nullable',
      ]);
      Company::find($company->id)->update([
        'name' => $data['name'],
        'type' => $data['type'],
      ]);
      for ($i=0; $i < 2; $i++) {
        Address::find($data['id'.$i])->update([
          'name' => $data['addressName'.$i],
          'address' => $data['address'.$i],
          'phone' => $data['phone'.$i],
        ]);
      }
      return redirect(action('CompanyController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    /**
    * AJAX SECTION
    */
    public function getCompanyData(Request $request)
    {
      if ($request->ajax()) {
        $project = Project::find($request->id);
        $company = Company::with('addresses')->where('id',$project->company_id)->get();
        return response()->json($company);
      }
    }
}
