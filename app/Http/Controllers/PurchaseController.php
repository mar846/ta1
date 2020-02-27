<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Address;
use App\Company;
use App\Designer;
use App\Good;
use App\Unit;
use App\Project;
use App\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $purchase = Purchase::all();
      return view('purchases.index',compact('purchase'));
    }
    public function price()
    {
      $designer = Designer::with(['goods'])->where('supervisor_id', '!=', null)->get();
      return view('purchases.price',compact('designer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create',Purchase::class);
      $company = Company::IsSupplier()->get();
       $good = Good::all();
       $unit = Unit::limit(3)->get();
       $project = Project::all();
       return view('purchases.add',compact('company', 'good', 'unit', 'project'));
    }
    public function quotation(Request $request)
    {
      $this->authorize('create',Purchase::class);
      $data = $request->validate([
        'project' => 'required|numeric',
      ],[
        'project.numeric' => 'You have to choose a project',
      ]);
      $project = Project::with(['companies.addresses','designers.goods.units'])->find($data['project']);
      // dd($project);
      return view('purchases.quotation', compact('project'));
    }
    public function addQuotation($project, $company)
    {
      $this->authorize('create',Purchase::class);
      $project = Project::with(['companies.addresses','designers.goods.units'])->find($project);
      $company = Company::find($company);
      $company = $company;
      // dd($good);
      return view('purchases.makeQuotation', compact('project','company'));
    }
    public function request()
    {
      $this->authorize('create',Purchase::class);
      $designer = Designer::with(['goods','projects'])->whereNull('supervisor_id')->get();
      return view('purchases.request', compact('designer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create',Purchase::class);
      $data = $request->validate([
        'project' => 'required|numeric',
        'company' => 'required|numeric',
        'address' => 'required|numeric',
        'phone' => '',
        'reference' => 'required',
        'referenceDate' => 'required',
        'paymentTerms' => 'required',
        'deliveryTime' => 'required',
      ]);
      $designer = Designer::with('goods.units')->where('project_id',$data['project'])->get();
      $totalItem = 0;
      $goods = [];
      foreach ($designer as $key => $value) {
        foreach ($value->goods as $index => $content) {
          if ($content['company_id'] == $data['company']) {
            $goods[] = $content['id'];
            $totalItem += 1;
          }
        };
      }
      $itemRules = [];
      for ($i=0; $i < $totalItem; $i++) {
        $itemRules['qty'.$i] = 'numeric';
        $itemRules['price'.$i] = 'numeric';
        $itemRules['subtotal'.$i] = 'numeric';
      }
      $itemData = $request->validate($itemRules);
      $total = 0;
      for ($i=0; $i < $totalItem; $i++) {
        if (isset($itemData['qty'.$i])) {
          $total += $itemData['price'.$i] * $itemData['qty'.$i];
        }
      }
      // $supplier = Address::SearchOrInsert($data, 'address', 'supplier');
      $countPurchase = Purchase::CountPurchase();
      $purchase = Purchase::create([
        'project_id' => $data['project'],
        'address_id' => $data['company'],
        'po' => $countPurchase.date('Ymd',time()),
        'reference' => $data['reference'],
        'paymentTerms' => $data['paymentTerms'],
        'deliveryTime' => $data['deliveryTime'],
        'downPayment' => '0',
        'user_id' => Auth::user()->id,
        'referenceDate' => date('Y-m-d', strtotime($data['referenceDate'])),
        'total' => $total,
      ]);
      for ($i=0; $i < $totalItem ; $i++) {
          // $good = Good::SearchOrInsert($itemData, $i, '');
          $purchase->goods()->syncWithoutDetaching([
          $goods[$i] => [
            'qty' => $itemData['qty'.$i],
            'price' => $itemData['price'.$i],
            'subtotal' => $itemData['price'.$i]*$itemData['qty'.$i],
            'memo' => '',
          ]
        ]);
      }
      return redirect(action('PurchaseController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
      $this->authorize('view',$purchase);
      $purchase = Purchase::find($purchase->id);
      return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
      $this->authorize('update',$purchase);
      $purchase = Purchase::find($purchase->id);
      return view('purchases.edit',compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
      $this->authorize('update',$purchase);
      $data = $request->validate([
        'supplier' => 'required',
        'address' => 'required',
        'reference' => 'required',
        'referenceDate' => 'required',
        'paymentTerms' => 'required',
        'deliveryTime' => 'required',
      ]);
      $purchase = Purchase::Find($purchase->id);
      Address::find($purchase->address_id)->update(['address' => $data['address']]);
      $address = Address::find($purchase->address_id);
      Company::find($address->company_id)->update(['name' => $data['supplier']]);
      Purchase::find($purchase->id)->update([
        'reference' => $data['reference'],
        'referenceDate' => $data['referenceDate'],
        'paymentTerms' => $data['paymentTerms'],
        'deliveryTime' => $data['deliveryTime'],
      ]);
      return redirect(action('PurchaseController@show',$purchase->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    public function makeInvoice(Purchase $purchase)
    {
      $this->authorize('view',$purchase);
      $purchase = Purchase::find(1);
      return view('prints.invoice',compact('purchase'));
    }
}
