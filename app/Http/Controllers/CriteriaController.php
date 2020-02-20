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

      // step 1
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

      // dd($times);
      // end of step 1

      // concordance discordance
      echo "<br>";
      $item = [];
      $j=0;
      foreach ($good as $key => $value) {
        foreach ($times as $index => $data) {
          foreach ($data as $i => $content) {
            if ($i == $value['name']) {
              $item[$j][$index] = $content;
              echo $content.' | ';
            }
          }
        }
        echo "<br>";
        $j++;
      }
      echo "<br>";
      $goodCount = Good::where('type','Panel')->count();
      $c = [];
      $d = [];
      echo "CXX --> Capacity, Price, QTY<br>";
      for ($i=0; $i < $goodCount; $i++) {
        for ($j=0; $j < $goodCount; $j++) {
          $bool = true;
          foreach ($item as $key => $value) {
            foreach ($value as $index => $data) {
              if ($i != $j) {
                if ($bool == true) {
                  echo 'C'.($i+1).($j+1).' -->';
                  if ($item[$i]['capacity']>=$item[$j]['capacity']) {
                    echo "| yes ";
                    $c[($i+1).($j+1)][]='capacity';
                  }
                  else {
                    echo "| no ";
                    $d[($i+1).'|'.($j+1)][] = 'capacity';
                  }
                  if ($item[$i]['price']>=$item[$j]['price']) {
                    echo "| yes ";
                    $c[($i+1).($j+1)][]='price';
                  }
                  else {
                    echo "| no ";
                    $d[($i+1).'|'.($j+1)][] = 'price';
                  }
                  if ($item[$i]['qty']>=$item[$j]['qty']) {
                    echo "| yes ";
                    $c[($i+1).($j+1)][]='qty';
                  }
                  else {
                    echo "| no ";
                    $d[($i+1).'|'.($j+1)][] = 'qty';
                  }
                  echo "<br>";
                  $bool = false;
                }
              }
            }
          }
        }
      }
      //concordance threshold
      $concordance=[];
      foreach ($c as $key => $value) {
        $totalWeight = 0;
        foreach ($value as $index => $data) {
          $totalWeight += $weight[$data];
        }
        $concordance[$key] = $totalWeight;
      }
      $concordanceThreshold = round(array_sum($concordance)/($goodCount*($goodCount-1)),4);
      foreach ($concordance as $key => $value) {
        $concordance[$key] = ($concordance[$key] > $concordanceThreshold)?1:0;
      }
      for ($i=0; $i < $goodCount; $i++) {
        for ($j=0; $j < $goodCount; $j++) {
          if ($i!=$j) {
            if (!isset($concordance[($i+1).($j+1)])) {
              $concordance[($i+1).($j+1)] = 0;
            }
          }
        }
      }
      // reorder concordance array
      ksort($concordance);
      //discordance threshold
      $discordance = [];
      $dividen = [];
      $divisor = [];
      $test = [];
      // get dividen and divisor value
      foreach ($d as $key => $value) {
        $bool = true;
        foreach ($value as $index => $data) {
          $up =  (substr($key ,0,strpos($key,'|'))*1);
          $down =  (substr($key ,strpos($key,'|')+1)*1);
          $dividen[$up.$down][] = abs($item[($up-1)][$data]-$item[($down-1)][$data]);
          foreach ($criteria as $i => $content) {
            $value = abs($item[($up-1)][strtolower($content['name'])]-$item[($down-1)][strtolower($content['name'])]);
            if ($bool == true) {
              $divisor[$up.$down][] = $value;
              // echo abs($item[($up-1)][strtolower($content['name'])]-$item[($down-1)][strtolower($content['name'])]).'<br>';
            }
          }
          $bool = false;
        }
      }
      // get dividen max value each row
      foreach ($dividen as $key => $value) {
        $dividen[$key] = max($dividen[$key]);
      }
      // get divisor max value each row
      foreach ($divisor as $key => $value) {
        $divisor[$key] = max($divisor[$key]);
      }
      $divide = [];
      // get dividen and divisor divide
      foreach ($divisor as $key => $value) {
        $divide[$key] = round($dividen[$key]/$divisor[$key],4);
      }
      // insert to threshold
      $discordanceThreshold = round(array_sum($divide)/($goodCount*($goodCount-1)),4);
      foreach ($divide as $key => $value) {
        $discordance[$key] = ($divide[$key] > $discordanceThreshold)?1:0;
      }
      echo "<br>";
      for ($i=0; $i < $goodCount; $i++) {
        for ($j=0; $j < $goodCount; $j++) {
          if ($i!=$j) {
            if (!isset($discordance[($i+1).($j+1)])) {
              $discordance[($i+1).($j+1)] = 0;
            }
          }
        }
      }
      // reorder discordance array
      ksort($discordance);
      echo "concordance<br>";
      print_r($concordance);
      echo "<br>discordance<br>";
      print_r($discordance);
      echo "<br>";
      //determined dominance matrix
      $dominance = [];
      for ($i=0; $i < $goodCount; $i++) {
        for ($j=0; $j < $goodCount; $j++) {
          if ($i!=$j) {
            if ($concordance[($i+1).($j+1)] == $discordance[($i+1).($j+1)]) {
              $dominance = ($i+1);
            }
          }
        }
      }
      echo "<br><br>";
      foreach ($good as $key => $value) {
        if ($value['id'] == $dominance) {
          $winner = $value['name'];
        }
      }
      echo "Winner is ".$winner;
      // print_r($concordance);
      // print_r($item);
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
