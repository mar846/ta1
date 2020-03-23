<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;

use App\Designer;
use App\File;
use App\Good;
use App\Unit;
use App\Project;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DesignerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('viewAny',Designer::class);
      $designer = Designer::all();
      return view('designers.index',compact('designer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create',Designer::class);
      $project = Project::all();
      $good = Good::all();
      $unit = Unit::all();
      return view('designers.add',compact('project','good','unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create',Designer::class);
      $data = $request->validate([
        'project' => 'required|numeric',
        'totalItem' => 'required|numeric',
      ],[
        'project.numeric' => 'You need to choose a project',
      ]);
      $itemRules=[];
      for ($i=0; $i < $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'required';
        $itemRules['qty'.$i] = 'required|numeric|min:1';
        $itemRules['unit'.$i] = 'required';
      }
      $itemData = $request->validate($itemRules);
      $designer = Designer::create([
        'project_id' => $data['project'],
        'user_id' => Auth::user()->id,
      ]);
      if ($request->hasFile('files')) {
        $allowedfileExtension=['pdf','jpg','png','docx','png','xlsx'];
        $files = $request->file('files');
        foreach ($files as $value) {
          $filename = $value->getClientOriginalName();
          $extention = $value->getClientOriginalExtension();
          $check = in_array($extention,$allowedfileExtension);
          if ($check) {
            File::create([
              'name' => Storage::disk('public')->putFileAs('designers', $value, $filename),
              'type' => 'designer',
              'project_id' => $data['project'],
              'user_id' => Auth::user()->id,
            ]);
          }
        }
      }
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        if ($itemData['item'.$i] != '') {
          $good = Good::SearchOrInsert($itemData, $i, 'Product');
          $designer->goods()->attach([
            $good['id'] => [
              'qty' => $itemData['qty'.$i],
              'status' => 'waiting',
              'created_at' => now(),
              'updated_at' => now(),
            ]
          ]);
        }
      }
      Project::find($data['project'])->update(['designer'=>$designer->id]);
      return redirect(action('DesignerController@show',$designer));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function show(Designer $designer)
    {
      $this->authorize('view',$designer);
      $designer = Designer::find($designer->id);
      return view('designers.show',compact('designer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function edit(Designer $designer)
    {
      $this->authorize('update',$designer);
      $designer = Designer::find($designer->id);
      $good = Good::all();
      $unit = Unit::all();
      return view('designers.edit',compact('designer','good','unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designer $designer)
    {
      $this->authorize('update',$designer);
      $data = $request->validate([
        'totalItem' => 'required|numeric',
      ]);
      $itemRules=[];
      for ($i=0; $i < $data['totalItem']; $i++) {
        $itemRules['item'.$i] = 'nullable';
        $itemRules['qty'.$i] = 'nullable|numeric|min:1';
        $itemRules['unit'.$i] = 'nullable';
      }
      $itemData = $request->validate($itemRules);
      for ($i=0; $i < $data['totalItem'] ; $i++) {
        if (isset($itemData['item'.$i])) {
          if ($itemData['item'.$i] != null) {
            $good = Good::SearchOrInsert($itemData,$i,'Product');
            $designer->goods()->detach($good['id']);
            $designer->goods()->syncWithoutDetaching([
              $good['id'] => [
                'qty' => $itemData['qty'.$i],
                'status' => 'waiting',
              ]
            ]);
          }
        }
      }
      return redirect(action('DesignerController@show',$designer->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designer  $designer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designer $designer)
    {
      $this->authorize('delete',$designer);
        //
    }
    public function deleteGood(Request $request)
    {
      if ($request->ajax()) {
        $designer = Designer::find($request['designer']);
        $designer->goods()->detach($request['id']);
      }
    }

    public function requestApprove(Designer $designers, $designer, $id)
    {
      $this->authorize('approval',$designers);
      $designer = Designer::find($designer);
      $designer->goods()->syncWithoutDetaching([
        $id => [
          'status' => 'Approved',
        ]
      ]);
      return redirect(action('DesignerController@show',$designer));
    }
    public function requestDisapprove(Request $request, $id, $good)
    {
      // $this->authorize('approval',Purchase::class);
      $rule['reason'.$good] = 'required|max:191';
      $acknowledge['reason'.$good.'.required'] = 'Rejection reason must be filled';
      $data = $request->validate($rule,$acknowledge);
      $designer = Designer::find($id);
      $designer->goods()->syncWithoutDetaching([
        $good => [
          'status' => $data['reason'.$good],
        ]
      ]);
      return redirect(action('DesignerController@show',$id));
    }
    public function approve(Designer $designer, $id)
    {
      $this->authorize('approval', $designer);
      Designer::find($id)->update([
        'supervisor_id' => Auth::user()->id,
      ]);
      return redirect(action('DesignerController@index'));
    }
    public function disapprove(Designer $designer, $id)
    {
      $this->authorize('approval', $designer);
      Designer::find($id)->update([
        'supervisor_id' => null,
      ]);
      return redirect(action('DesignerController@index'));
    }
    public function getDesignerData(Request $request)
    {
      $designer = Designer::with(['goods.units'])->where('project_id',$request['id'])->get();
      return response()->json($designer);
    }
    public function getProjectDetail(Request $request)
    {
      echo "string";
    }
}
