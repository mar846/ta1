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
      $project = Project::all();
      return view('purchases.add',compact('project'));
    }
    public function quotation(Request $request)
    {
      $this->authorize('create',Purchase::class);
      $data = $request->validate([
        'project' => 'required|numeric',
      ]);
      $project = Project::with(['companies.addresses','designers.goods.units'])->find($data['project']);
      // dd($project);
      return view('purchases.quotation', compact('project'));
    }
    public function request()
    {
      $this->authorize('create',Purchase::class);
      $designer = Designer::with(['goods','projects'])->whereNull('supervisor_id')->get();
      return view('purchases.request', compact('designer'));
    }
    public function requestApprove($id, $good)
    {
      $this->authorize('create',Purchase::class);
      $designer = Designer::find($id);
      $designer->goods()->syncWithoutDetaching([
        $good => [
          'status' => 'Approved',
        ]
      ]);
      return redirect(action('PurchaseController@request'));
    }
    public function requestDispprove($id, $good)
    {
      $this->authorize('create',Purchase::class);
      $designer = Designer::find($id);
      $designer->goods()->syncWithoutDetaching([
        $good => [
          'status' => 'Rejected',
        ]
      ]);
      return redirect(action('PurchaseController@request'));
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
        'company' => 'required',
        'address' => 'required',
        'phone' => '',
        'reference' => '',
        'referenceDate' => '',
        'paymentTerms' => 'required',
        'deliveryTime' => 'required',
        'totalItem' => 'bail|required|numeric|min:1',
      ]);
      $itemRules=[];
      for ($i=0; $i < $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
        $itemRules['price'.$i] = 'nullable|numeric|min:1';
        $itemRules['subtotal'.$i] = 'nullable|numeric|min:1';
      }
      $itemData = $request->validate($itemRules);
      $supplier = Address::SearchOrInsert($data, 'address', 'supplier');
      $countPurchase = Purchase::CountPurchase();
      $purchase = Purchase::create([
        'project_id' => $data['project'],
        'address_id' => $supplier['id'],
        'po' => $countPurchase.date('Ymd',time()),
        'reference' => $data['reference'],
        'paymentTerms' => $data['paymentTerms'],
        'deliveryTime' => $data['deliveryTime'],
        'downPayment' => '0',
        'user_id' => Auth::user()->id,
        'referenceDate' => date('Y-m-d', strtotime($data['referenceDate'])),
        'total' => '7750000',
      ]);
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        if ($itemData['item'.$i] != '') {
          $good = Good::SearchOrInsert($itemData, $i, '');
          $purchase->goods()->syncWithoutDetaching([
            $good['id'] => [
              'qty' => $itemData['qty'.$i],
              'price' => $itemData['price'.$i],
              'subtotal' => $itemData['price'.$i]*$itemData['qty'.$i],
              'memo' => '',
            ]
          ]);
          $good->companies()->syncWithoutDetaching([
            $supplier['company_id'] => [
              'created_at' => now(),
              'updated_at' => now(),
            ]
          ]);
        }
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
