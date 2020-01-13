<?php

namespace App\Http\Controllers;

use DB;
use App\Warehouse;
use App\Panel;
use App\Inverter;
use App\Sale;
use App\Purchase;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
      return view('reports.report');
    }
    public function show($page)
    {
      if ($page == 1) {
        $warehouse = Warehouse::all();
        return view('reports.reportWarehouse',compact('warehouse'));
      }
      elseif ($page == 2) {
        $panel = Panel::all();
        $inverter = Inverter::all();
        return view('reports.reportGood',compact('panel','inverter'));
      }
      elseif ($page == 3) {
        // code...
      }
      $warehouse = Warehouse::all();
      // $warehouse->inverters()->syncWithoutDetaching(['qty' => rand(1,10)]);
      // if ($page =='1') {
      //   $warehouse = Warehouse::all();
        return view('reports.reportWarehouse',compact('warehouse'));
      // }
    }
}
