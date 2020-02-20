<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Criteria;
use App\Good;
use App\Project;

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria)
    {
      $this->authorize('update', $criteria);
      $criteria = Criteria::find($criteria->id);
      return view('criterias.edit',compact('criteria'));
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
      $data = $request->validate([
        'weight' => 'required|numeric|min:1|max:5',
      ]);
      Criteria::find($criteria->id)->update($data);
      return redirect(action('CriteriaController@index'));
    }

    public function electre(Request $request)
    {
      if ($request->ajax()) {
        $project = Project::find($request['id']);
        $capacity =0;
        if ($project['unit'] == 'MW') {
          $capacity = $project['capacity']*1000000*1.05;
        }
        elseif ($project['unit'] == 'KW') {
          $capacity = $project['capacity']*1000*1.05;
        }
        elseif ($project['unit'] == 'W') {
          $capacity = $project['capacity']*1.05;
        }
        $good = Good::with(['units','types'])->where('type_id','1')->orderBy('capacity','asc')->get();
        $criteria = Criteria::all();
        // get scale raw data
        $scale = [];
        foreach ($good as $key => $value) {
          $scale['capacity'][$value['name']]=$value['capacity'];
          $scale['price'][$value['name']]=$value['price'];
          $scale['qty'][$value['name']]=ceil($capacity/$value['capacity']);
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
            $scale['qty'][$i] =  $scale['qty'][$i-1] +  $increment['qty'];
          }
          else {
            $scale['capacity'][$i] = $scaleMaxMin['min']['capacity']+ $increment['capacity'];
            $scale['price'][$i] = $scaleMaxMin['min']['price']+ $increment['price'];
            $scale['qty'][$i] = $scaleMaxMin['min']['qty']+ $increment['qty'];
          }
        }
        // data from database to array
        $goodSort = [];
        foreach ($good as $key => $value) {
          $goodSort['capacity'][$value['name']]= $value['capacity'];
          $goodSort['price'][$value['name']]= $value['price'];
          $goodSort['qty'][$value['name']]= ceil($capacity/$value['capacity']);
        }
        // Sort small to large
        foreach ($goodSort as $key => $value) {
          ksort($goodSort[$key]);
        }
        // step 1
        // scoring
        $score = [];
        foreach ($goodSort as $key => $value) {
          foreach ($value as $index => $data) {
            foreach ($scale as $i => $content) {
              foreach ($content as $iteration => $info) {
                if ($key == $i) {
                  if ($data<$content[0]) {
                    if (!isset($score[$key][$index])) {
                      $score[$key][$index] = $iteration+1;
                    }
                  }
                  elseif ($data>$content[$iteration]) {
                    $score[$key][$index] = $iteration+2;
                  }
                }
              }
            }
          }
        }
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
        // end of step 1
        // step 2
        // concordance discordance
        $item = [];
        $j=0;
        foreach ($good as $key => $value) {
          foreach ($times as $index => $data) {
            foreach ($data as $i => $content) {
              if ($i == $value['name']) {
                $item[$j][$index] = $content;
              }
            }
          }
          $j++;
        }
        $goodCount = Good::where('type_id','1')->count();
        $c = [];
        $d = [];
        for ($i=0; $i < $goodCount; $i++) {
          for ($j=0; $j < $goodCount; $j++) {
            $bool = true;
            foreach ($item as $key => $value) {
              foreach ($value as $index => $data) {
                if ($i != $j) {
                  if ($bool == true) {
                    if ($item[$i]['capacity']>=$item[$j]['capacity']) {
                      $c[($i+1).($j+1)][]='capacity';
                    }
                    else {
                      $d[($i+1).'|'.($j+1)][] = 'capacity';
                    }
                    if ($item[$i]['price']>=$item[$j]['price']) {
                      $c[($i+1).($j+1)][]='price';
                    }
                    else {
                      $d[($i+1).'|'.($j+1)][] = 'price';
                    }
                    if ($item[$i]['qty']>=$item[$j]['qty']) {
                      $c[($i+1).($j+1)][]='qty';
                    }
                    else {
                      $d[($i+1).'|'.($j+1)][] = 'qty';
                    }
                    $bool = false;
                  }
                }
              }
            }
          }
        }
        // end of step 2
        // step 3
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
        // end of step 3
        // step 4
        //determined dominance matrix
        $dominance = [];
        for ($i=0; $i < $goodCount; $i++) {
          for ($j=0; $j < $goodCount; $j++) {
            if ($i!=$j) {
              if ($concordance[($i+1).($j+1)] == $discordance[($i+1).($j+1)]) {
                $dominance = $i;
              }
            }
          }
        }
        foreach ($good as $key => $value) {
          if ($value['id'] == $dominance) {
            $winner['name'] = $value['name'];
            $winner['qty'] = ceil($capacity/$value['capacity']);
            $winner['unit'] = $value['units']['name'];
          }
        }
        return $winner;
        // end of step 4
      }
    }

}
