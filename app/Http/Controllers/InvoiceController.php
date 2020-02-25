<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Invoice;
use App\Project;
use App\Sale;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $invoice = Invoice::all();
      return view('invoices.index', compact('invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Sale $sale)
    {
      // $sale = Sale::all();
      // return view('invoices.add',compact('sale','project'));
    }
    public function makeInvoice($id)
    {
      $sale = Sale::find($id);
      return view('invoices.add',compact('sale'));
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
        'amount' => 'required|numeric|min:1',
        'sale' => 'required|numeric',
      ]);
      $invoice = Invoice::create([
        'sale_id' => $data['sale'],
        'user_id' => Auth::user()->id,
        'amount' => $data['amount'],
      ]);
      return redirect(action('InvoiceController@show',$invoice));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
      $invoice = Invoice::find($invoice->id);
      $sale = Sale::find($invoice->sales->id);
      $totalInvoice = Invoice::where([['sale_id',$sale->id],['id','!=',$invoice->id]])->get();
      $total = 0;
      foreach ($totalInvoice as $key => $value) {
        $total += $value['amount'];
      }
      $downpayment = 0;
      $type = null;
      if (($sale->total - $total) == 0) {
        $downpayment = ($sale->total - $invoice->amount);
        $repayment = $invoice->amount;
        $type = 'lunas';
      }
      else {
        $type = 'dp';
        $downpayment = ($sale->total - $invoice->amount);
        $repayment = $invoice->amount;
      }
      return view('prints.saleInvoice',compact('invoice','downpayment','repayment','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
