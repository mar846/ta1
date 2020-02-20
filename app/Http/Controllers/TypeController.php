<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('viewAny', Type::class);
        $type = Type::all();
        return view('types.index', compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('create', Type::class);
        $type = Type::all();
        return view('types.add', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('create', Type::class);
        $data = $request->validate([
          'name' => 'required|unique:types|max:191',
        ]);
        Type::find($type->id)->update($data);
        return redirect(action('TypeController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {

        $this->authorize('view', $type);
        $type = Type::find($type->id);
        return view('types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {

        $this->authorize('update', $type);
        $type = Type::find($type->id);
        return view('types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {

        $this->authorize('update', $type);
        $data = $request->validate([
          'name' => 'required|unique:types|max:191',
        ]);
        Type::find($type->id)->update($data);
        return redirect(action('TypeController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {

        $this->authorize('delete', $type);
    }
}
