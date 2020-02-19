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
      $this->authorize('create', Company::class);
      $data = $request->validate([
        'name' => 'required|unique:companies|max:191',
        'address' => 'required|max:191',
        'branch' => '',
        'phone' => 'nullable|numeric',
        'type'=>'required'
      ]);
      $insertCompany = Company::create([
        'name' => $data['name'],
        'type' => $data['type'],
      ]);
      $insertAddress = Address::create([
        'company_id' => $insertCompany['id'],
        'name' => $data['branch'],
        'address' => $data['address'],
        'phone' => $data['phone'],
      ]);
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
        'name'=>'bail|required|max:191',
        'address'=>'bail|required|max:191',
        'phone'=>'bail|nullable',
      ]);
      Company::find($company->id)->update($data);
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
