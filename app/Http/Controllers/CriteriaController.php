<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Criteria;
use App\Good;

use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('viewAny', Criteria::class);
      $criteria = Criteria::all();
      return view('criterias.index', compact('criteria'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Criteria::class);
      $good = Good::where('type','Panel')->get();
      $criteria = Criteria::all();
      // get scale raw data
      $scale = [];
      foreach ($good as $key => $value) {
        $scale['capacity'][$value['name']]=$value['capacity'];
        $scale['price'][$value['name']]=$value['price'];
        $scale['qty'][$value['name']]=ceil(1000000/$value['capacity']);
      }
      // get scale max min
      $scaleMaxMin = [];
      foreach ($scale as $key => $value) {
        foreach ($value as $index => $data) {
          $scaleMaxMin['max'][$key] = max($value);
          $scaleMaxMin['min'][$key] = min($value);
        }
      }
      // calculate scale increment
      $increment = [];
      foreach ($scaleMaxMin  as $key => $value) {
        foreach ($value as $index => $data) {
          $increment[$index] =  (($scaleMaxMin['max'][$index]-$scaleMaxMin['min'][$index])/5);
        }
      }
      // make scale
      $scale = [];
      for ($i=0; $i < 5; $i++) {
        if ($i!= 0) {
          $scale['capacity'][$i] =  $scale['capacity'][$i-1] +  $increment['capacity'];
          $scale['price'][$i] =  $scale['price'][$i-1] +  $increment['price'];
          $scale['qty'][$i] =  $scale['qty'][$i-1] -  $increment['qty'];
        }
        else {
          $scale['capacity'][$i] = $scaleMaxMin['min']['capacity']+ $increment['capacity'];
          $scale['price'][$i] = $scaleMaxMin['min']['price']+ $increment['price'];
          $scale['qty'][$i] = $scaleMaxMin['max']['qty'];
        }
      }
      // data from database to array
      $goodSort = [];
      foreach ($good as $key => $value) {
        $goodSort['capacity'][$value['name']]= $value['capacity'];
        $goodSort['price'][$value['name']]= $value['price'];
        $goodSort['qty'][$value['name']]= ceil(1000000/$value['capacity']);
      }
      // Sort small to large
      foreach ($goodSort as $key => $value) {
        asort($goodSort[$key]);
      }
      foreach ($scale as $key => $value) {
        echo '<br><br>'.$key.'<br>';
        foreach ($value as $index => $data) {
          echo ($index+1).' - '.$data.'<br>';
        }
      }
      // scoring
      $score = [];
      foreach ($good as $key => $value) {
        foreach ($scale as $index => $data) {
          foreach ($data as $i => $content) {
            if ($index == 'price') {
              if ($value['price'] <= $data[0]) {
                $score['price'][$value['name']] = 1;
              }
              elseif ($value['price'] >= $data[$i]) {
                $score['price'][$value['name']] = $i+1;
              }
            }
            if ($index == 'capacity') {
              if ($value['capacity'] <= $data[0]) {
                $score['capacity'][$value['name']] = 1;
              }
              elseif ($value['capacity'] >= $data[$i]) {
                $score['capacity'][$value['name']] = $i+1;
              }
            }
            if ($index == 'qty') {
              if (ceil(1000000/$value['capacity']) <= $data[$i]) {
                $score['qty'][$value['name']] = $i+1;
              }
            }
          }
        }
      }
      //power
      $power =[];
      $total =[];
      foreach ($score as $key => $value) {
        foreach ($value as $index => $data) {
          $power[$key][$index] = pow($data,2);
        };
        $total[$key] = array_sum($power[$key]);
      };
      $sqrt =[];
      //sqrt
      foreach ($total as $key => $value) {
        $sqrt[$key] = round(sqrt($value),4);
      };
      $divison = [];
      foreach ($score as $key => $value) {
        foreach ($value as $index => $data) {
          $divison[$key][$index] = round(($data/$sqrt[$key]),4);
        }
      }
      foreach ($criteria as $key => $value) {
        $weight[strtolower($value['name'])] = $value['weight'];
      }
      $times = [];
      foreach ($divison as $key => $value) {
        foreach ($value as $index => $data) {
          $times[$key][$index] = $data*$weight[$key];
        }
      }
      print_r($times);
      echo "<table>";
      foreach ($times as $key => $value) {
        echo "<tr><td>".$key."</td></tr><tr>";
        foreach ($value as $index => $data) {
          echo '<td>'.$data.'</td>';
        }
        echo "</tr>";
      }
      echo "</table>";

      // echo "<table><br>";
      // echo "<table><tr><td></td>";
      // foreach ($criteria as $key => $value) {
      //   echo '<td>'.$value['name'].'('.$value['weight'].')</td>';
      // }
      // echo '</tr>';
      // foreach ($good as $key => $value) {
      //   echo '<tr><td>'.$value['name'].'</td><td>'.number_format(pow($value['capacity'],2),0,',','.').'</td><td>'.number_format(pow($value['price'],2),0,',','.').'</td><td>'.number_format(pow(round(1000000/$value['capacity'],2),2),0,',','.').'</td></tr>';
      // }
      // echo "<table>";
      // echo '<br>';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Criteria::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function show(Criteria $criteria)
    {
      $this->authorize('view', $criteria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria)
    {
      $this->authorize('update', $criteria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Criteria $criteria)
    {
      $this->authorize('update', $criteria);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteria $criteria)
    {
      $this->authorize('delete', $criteria);
    }
}
