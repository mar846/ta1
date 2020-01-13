<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use App\Sale;
use App\Company;
use App\Panel;
use App\Inverter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $sale = Sale::all();
      return view('sales.sale',compact('sale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $company = Company::where('type','costumer')->get();
      $panel = Panel::all();
      $inverter = Inverter::all();
      return view('sales.saleAdd',compact('company','panel','inverter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create',Sale::class);
      // $data = $request->validate([
      //   'costumer'=>'required|max:191',
      //   'address'=>'required|max:191',
      //   'phone'=>'required|numeric',
      //   'reference'=>'',
      //   'referenceDate'=>'date',
      // ]);
      $companyID = Company::SearchID($request['costumer'])->first();
      if ($companyID ==   null) {
        $companyID = Company::create(['name'=>$request['costumer'], 'address'=>$request['address'], 'phone'=>$request['phone'], 'type'=>'costumer']);
      }
      $sale = Sale::create([
        'company_id' => $companyID->id,
        'so' => str_pad(date('y',time()), 3, '0').'1',
        'reference' => $request['reference'],
        'referenceDate' => date('Y-m-d',strtotime($request['referenceDate'])),
        'total' => '1000',
        'created_at' => time(),
        'updated_at' => time(),
      ]);
      for ($i=0; $i <= $request['totalItem'] ; $i++) {
        if ($request['item'.$i] != '') {
          $panelID = Panel::SearchID($request['item'.$i])->first();
          $inverterID = Inverter::SearchID($request['item'.$i])->first();
          
        }
      }
      // return redirect(actionn('SaleController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
      return view('sales.saleShow',compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
      return view('sales.saleEdit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
