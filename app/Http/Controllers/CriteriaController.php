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
        // $project = Project::find(1);
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
        $good = Good::with(['units','types','spec'])->where('type_id','1')->orderBy('capacity','asc')->get();
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
                $dominance[$i][] = $i;
              }
            }
          }
        };
        foreach ($dominance as $key => $value) {
          $dominance[$key] = count($dominance[$key]);
        }
        $highest_num = max($dominance);
        $highest_key = max(array_keys($dominance,$highest_num));
        $winner['panel'] = $good[$highest_key]['name'];
        $winner['panelqty'] = ceil($capacity/$good[$highest_key]['capacity']);
        $winner['panelunit'] = $good[$highest_key]['units']['name'];






        // search Inverter
        $inverter = Good::where('type_id',2)->orderBy('capacity','asc')->get();
        $item = [];
        $inverterList = [];
        foreach ($inverter as $key => $value) {
          for ($i=1; $i < 6; $i++) {
            if ($value['capacity'] * $i > $capacity) {
              if (!isset($item[$value['id']])) {
                // echo $value['name'].' | '.$value['capacity'].' | '.$i.' | '.number_format($value['price'],0,',','.').' | '.number_format($i * $value['price'],0,',','.').' | '.($value['capacity'] * $i).'<br>';
                $choosen[$value['name']] = $value['name'].' & '.$i.' = '.$i*$value['capacity'].' | '.number_format($i*$value['price'],0,',','.');
                $item[$value['id']]['qty'] = $i;
                $item[$value['id']]['capacity'] = $i*$value['capacity'];
                $item[$value['id']]['price'] = $i*$value['price'];
                $inverterList[] = $value['id'];
              }
              // echo $value['name'].' * '.$i.' | '.number_format($capacity,0,',','.').' == '.number_format($i*$value['capacity'],0,',','.').'<br>';
            }
          }
        }
        $scale = [];
        foreach ($item as $key => $value) {
          $scale['capacity'][$key]=$item[$key]['capacity'];
          $scale['price'][$key]=$item[$key]['price'];
          $scale['qty'][$key]=$item[$key]['qty'];
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
        // dd($item);
        // data from database to array
        $inverterSort = [];
        foreach ($item as $key => $value) {
          $inverterSort['capacity'][$key]= $item[$key]['capacity'];
          $inverterSort['price'][$key]= $item[$key]['price'];
          $inverterSort['qty'][$key]= $item[$key]['qty'];
        }
        // Sort small to large
        foreach ($inverterSort as $key => $value) {
          ksort($inverterSort[$key]);
        }
        // step 1
        // scoring
        $score = [];
        foreach ($inverterSort as $key => $value) {
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
        $inverter = [];
        $j=0;
        foreach ($item as $key => $value) {
          foreach ($times as $index => $data) {
            foreach ($data as $i => $content) {
              if ($i == $key) {
                $inverter[$j][$index] = $content;
              }
            }
          }
          $j++;
        }
        $inverterCount = count($item);
        $c = [];
        $d = [];
        for ($i=0; $i < $inverterCount; $i++) {
          for ($j=0; $j < $inverterCount; $j++) {
            $bool = true;
            foreach ($inverter as $key => $value) {
              foreach ($value as $index => $data) {
                if ($i != $j) {
                  if ($bool == true) {
                    if ($inverter[$i]['capacity']>=$inverter[$j]['capacity']) {
                      // echo ($i+1).($j+1).' ca '.$inverter[$i]['capacity']." >= ".$inverter[$j]['capacity'].' | ';
                      $c[($i+1).($j+1)][]='capacity';
                    }
                    else {
                      // echo '<b>'.($i+1).($j+1).' da '.$inverter[$i]['capacity']." >= ".$inverter[$j]['capacity'].' | </b>';
                      $d[($i+1).'|'.($j+1)][] = 'capacity';
                    }
                    if ($inverter[$i]['price']>=$inverter[$j]['price']) {
                      // echo ($i+1).($j+1).' cb '.$inverter[$i]['price']." >= ".$inverter[$j]['price'].' | ';
                      $c[($i+1).($j+1)][]='price';
                    }
                    else {
                      // echo '<b>'.($i+1).($j+1).' db '.$inverter[$i]['price']." >= ".$inverter[$j]['price'].' | </b>';
                      $d[($i+1).'|'.($j+1)][] = 'price';
                    }
                    if ($inverter[$i]['qty']>=$inverter[$j]['qty']) {
                      // echo ($i+1).($j+1).' cd '.$inverter[$i]['qty']." >= ".$inverter[$j]['qty'].' | ';
                      $c[($i+1).($j+1)][]='qty';
                    }
                    else {
                      // echo '<b>'.($i+1).($j+1).' dd '.$inverter[$i]['qty']." >= ".$inverter[$j]['qty'].' | </b>';
                      $d[($i+1).'|'.($j+1)][] = 'qty';
                    }
                    $bool = false;
                  }
                }
              }
            }
            // echo "<br>";
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
        $concordanceThreshold = round(array_sum($concordance)/($inverterCount*($inverterCount-1)),4);
        foreach ($concordance as $key => $value) {
          $concordance[$key] = ($concordance[$key] > $concordanceThreshold)?1:0;
        }
        for ($i=0; $i < $inverterCount; $i++) {
          for ($j=0; $j < $inverterCount; $j++) {
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
            $dividen[$up.$down][] = abs($inverter[($up-1)][$data]-$inverter[($down-1)][$data]);
            foreach ($criteria as $i => $content) {
              $value = abs($inverter[($up-1)][strtolower($content['name'])]-$inverter[($down-1)][strtolower($content['name'])]);
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
        $discordanceThreshold = round(array_sum($divide)/($inverterCount*($inverterCount-1)),4);
        foreach ($divide as $key => $value) {
          $discordance[$key] = ($divide[$key] > $discordanceThreshold)?1:0;
        }
        for ($i=0; $i < $inverterCount; $i++) {
          for ($j=0; $j < $inverterCount; $j++) {
            if ($i!=$j) {
              if (!isset($discordance[($i+1).($j+1)])) {
                $discordance[($i+1).($j+1)] = 0;
              }
            }
          }
        }
        // reorder discordance array
        // end of step 3
        // step 4
        //determined dominance matrix
        $dominance = [];
        for ($i=0; $i < $inverterCount; $i++) {
          for ($j=0; $j < $inverterCount; $j++) {
            if ($i!=$j) {
              if ($concordance[($i+1).($j+1)] == $discordance[($i+1).($j+1)]) {
                $dominance[$i][] = $i;
              }
            }
          }
        };
        foreach ($dominance as $key => $value) {
          $dominance[$key] = count($dominance[$key]);
        }
        $highest_num = max($dominance);
        $inverter_highest_key = max(array_keys($dominance,$highest_num));
        $inverterWinner = Good::find($inverterList[$inverter_highest_key]);
        $winner['inverter'] = $inverterWinner['name'];
        $winner['inverterQty'] = $item[$inverterWinner['id']]['qty'];
        $winner['inverterUnit'] = $inverterWinner['units']['name'];

        $maxVolt = $inverterWinner['spec']['maxVolt'];
        $panel = Good::find($highest_key)->first();
        // dd($panel);
        $series = 0;
        for ($i=1; $i < 51; $i++) {
          if ((($panel['spec']['maxVolt'] * $i)*$panel['spec']['efficiency']/100) > $maxVolt) {
            $series =  $i-1;
            break;
          }
        }
        $seriesVolt = $series * $panel['spec']['maxVolt'];
        // dd($seriesVolt);
        // PV Combiner
        $parallel = null;
        for ($i=1; $i < 20; $i++) {
          // echo '('.$panel['spec']['maxCurrent'].' * '.$seriesVolt.' * '.$i.')'." > ".$capacity."<br>";
          if (($panel['spec']['maxCurrent'] * $seriesVolt * $i) > $capacity) {
            $parallel = $i-1;
            break;
          }
        }
        $winner['pvCombiner'] = 'PV Combiner';
        $winner['pvCombinerQty'] = $parallel;
        $winner['pvCombinerUnit'] = 'unit';
        $winner['sunLogger'] = 'Sun Logger';
        $winner['sunLoggerQty'] = 1;
        $winner['sunLoggerUnit'] = 'set';
        return $winner;
        // end of step 4
      }
    }
}
