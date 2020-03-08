<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Address;
use App\Sale;
use App\Company;
use App\Good;
use App\Unit;
use App\Project;
use App\Term;

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
      $this->authorize('viewAny',Sale::class);
      $sale = Sale::all();
      return view('sales.index',compact('sale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create',Sale::class);
      $project = Project::with(['companies.addresses','designers','sales'])->get();
      return view('sales.add', compact('project'));
    }
    public function quotation(Request $request)
    {
      $this->authorize('create',Sale::class);
      $data = $request->validate([
        'project' => 'required|numeric',
      ],[
        'project.numeric' => 'You have to choose a project',
      ]);
      $project = Project::with(['companies.addresses','designers.goods.units'])->find($data['project']);
      return view('sales.quotation', compact('project'));
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
      $data = $request->validate([
        'project'=>'required',
        'company'=>'required',
        'billTo'=>'required',
        'shipTo'=>'required',
        'phone'=>'nullable',
        'reference'=>'required',
        'referenceDate'=>'required',
        'deliveryTime'=>'required',
        'totalItem' => 'required|numeric',
        'totalTerm'=>'required|numeric',
      ]);
      $itemRules=[];
      for ($i=0; $i <= $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
        $itemRules['price'.$i] = 'nullable|numeric|min:1';
        $itemRules['subtotal'.$i] = 'nullable|numeric|min:1';
      }
      $itemData = $request->validate($itemRules);
      $termRules=[];
      for ($i=0; $i < $data['totalTerm']; $i++) {
        $termRules['percentage'.$i] = 'required|numeric';
        $termRules['description'.$i] = 'required';
      }
      $termData = $request->validate($termRules);
      $totalSale =0;
      for ($i=0; $i <= $data['totalItem'] ; $i++) {
        $totalSale += $itemData['qty'.$i]*$itemData['price'.$i];
      }
      if (Sale::where('project_id',$data['project'])->count() == 0) {
        $billTo = Address::SearchOrInsert($data,'billTo', 'customer');
        $shipTo = Address::SearchOrInsert($data, 'shipTo', 'customer');
        $countSale = Sale::CountSale();
        $sale = Sale::create([
          'project_id' => $data['project'],
          'user_id' => Auth::user()->id,
          'billTo' => $billTo['id'],
          'shipTo' => $shipTo['id'],
          'so' => str_pad(date('y',time()), 3, '0').$countSale,
          'reference' => $request['reference'],
          'version' => 1,
          'referenceDate' => date('Y-m-d',strtotime($request['referenceDate'])),
          'deliveryTime' => $data['deliveryTime'],
          'total' => $totalSale,
        ]);
        for ($i=0; $i < $data['totalTerm']; $i++) {
          Term::create([
            'sale_id' => $sale['id'],
            'percentage' => $termData['percentage'.$i],
            'description' => $termData['description'.$i],
            'created_at' => now(),
            'updated_at' => now(),
          ]);
        }
        for ($i=0; $i <= $data['totalItem']; $i++) {
          if ($itemData['item'.$i] != '') {
            $good = Good::SearchOrInsert($itemData, $i, 'Product');
            $sale->goods()->syncWithoutDetaching([
              $good['id'] => [
                'qty' => $itemData['qty'.$i],
                'price' => $itemData['price'.$i],
                'subtotal' => $itemData['qty'.$i]*$itemData['price'.$i],
                'memo' => '',
              ]
            ]);
          }
        }
        return redirect(action('SaleController@show',$sale->id));
      }
      else {
        return redirect(action('SaleController@index'))->with('status', 'Already Exists!');;
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
      $this->authorize('view', $sale);
      $sale = Sale::find($sale->id);
      return view('sales.show',compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
      $this->authorize('update', $sale);
      $sale = Sale::find($sale->id);
      return view('sales.edit',compact('sale'));
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
      $this->authorize('update', $sale);
      $sale = Sale::find($sale->id);
      $goodCount = null;
      $good = [];
      $qty = [];
      foreach ($sale->projects->designers as $key => $value) {
        foreach ($value->goods as $key => $value) {
          $goodCount = $key;
          $good[] = $value['id'];
          $qty[] = $value['pivot']['qty'];
        }
      }
      $data = $request->validate([
        'validTill' => 'required|date',
        'paymentTerms' => 'required',
        'deliveryTime' => 'required',
      ]);
      $itemRules = [];
      for ($i=0; $i <= $goodCount; $i++) {
        $itemRules['price'.$i] = 'nullable|numeric|min:1';
      }
      $total = null;
      $itemData = $request->validate($itemRules);
      for ($i=0; $i < $goodCount ; $i++) {
        $total += $qty[$i]*$itemData['price'.$i];
      }
      $newSale = Sale::create([
        'billTo' => $sale->bills->id,
        'shipTo' => $sale->ships->id,
        'so' => $sale->so,
        'total' => $total,
        'reference' => $sale->reference,
        'referenceDate' => $sale->referenceDate,
        'validTill' => $request['validTill'],
        'paymentTerms' => $request['paymentTerms'],
        'deliveryTime' => $request['deliveryTime'],
        'downPayment' => '0',
        'downPayment' => '0',
        'version' => Sale::where('project_id',$sale->project_id)->count()+1,
        'project_id' => $sale->project_id,
        'user_id' => Auth::user()->id,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
      for ($i=0; $i <= $goodCount; $i++) {
        $newSale->goods()->syncWithoutDetaching([
          $good[$i] => [
            'qty' => $qty[$i],
            'price' => $itemData['price'.$i],
            'subtotal' => $qty[$i]*$itemData['price'.$i],
            'memo' => '',
          ]
        ]);
      }
      return redirect(action('SaleController@show',$newSale->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
      $this->authorize('delete', $sale);
        //
    }

    public function approve(Sale $sale,$id)
    {
      $this->authorize('approval',$sale);
      Sale::find($id)->update([
        'supervisor_id' => Auth::user()->id,
      ]);
      return redirect(action('SaleController@index'));
    }
    public function disapprove(Sale $sale, $id)
    {
      $this->authorize('approval',$sale);
      Sale::find($id)->update([
        'supervisor_id' => null,
      ]);
      return redirect(action('SaleController@index'));
    }
    public function makeInvoice(Sale $sale)
    {
      $this->authorize('view',$sale);
      dd($sale);
      $sale = Sale::find(1);
      return view('prints.saleInvoice',compact('sale'));
    }
}
