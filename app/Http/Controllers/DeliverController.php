<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Validator;

use App\Deliver;
use App\Sale;

use Illuminate\Http\Request;

class DeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $sale = Sale::where('supervisor_id','!=',null)->get();
      return view('delivers.index',compact('sale'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $sale = Sale::find($request['id']);
      return view('delivers.add',compact('sale'));
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
        'id' => 'required|numeric|min:1'
      ]);
      $sale = Sale::find($data['id']);
      $goodCount = count($sale->goods);
      $itemRules = [];
      for ($i=0; $i < $goodCount; $i++) {
        $itemRules['qty'.$i] = "nullable|numeric|min:1";
      }
      $good = [];
      foreach ($sale->goods as $key => $value) {
        $good[] = $value['id'];
      }
      $itemData = $request->validate($itemRules);
      $deliver = Deliver::create([
        'sale_id' => $sale->id,
        'user_id' => Auth::user()->id,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
      for ($i=0; $i < $goodCount; $i++) {
        echo $good[$i].' = '.$itemData['qty'.$i].'<br>';
        $deliver->goods()->attach([
          $good[$i] => [
            'qty' => $itemData['qty'.$i],
            'created_at' => now(),
            'updated_at' => now(),
          ]
        ]);
      }
      return redirect(action('DeliverController@show',$deliver->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function show(Deliver $deliver)
    {
      $this->authorize('view',$deliver);
      $deliver = Deliver::find($deliver->id);
      return view('prints.deliveryNote',compact('deliver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function edit(Deliver $deliver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deliver $deliver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deliver $deliver)
    {
        //
    }
}
