<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Position;
use App\Staff;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('level');
    }

    public function index()
    {
        $position = Position::all();
        return view('admin.position.list', compact('position'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.position.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'txtName' => 'required', 
            'rActive' => 'required|in:0,1',
        ]);

        $position = new Position();
        $position->name = $request->txtName;
        $position->active = $request->rActive;
        $position->save();
        return redirect()->route('admin.position.index')->with('message', 'Create position success!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::find($id);
        return view('admin.position.update', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'txtName' => 'required', 
            'rActive' => 'required|in:0,1',
        ]);

        $position = Position::find($id);
        $position->name = $request->txtName;
        $position->active = $request->rActive;
        $position->save();
        return redirect()->route('admin.position.index')->with('message', 'Update position success!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findPosition = Staff::where('position_id', $id)->get()->toArray();
        if(!empty($findPosition)){
            return redirect()->route('admin.position.index')->with('message', 'Can\'t delete position !');
        }
        $position = Position::find($id);
        $position->delete();
        return redirect()->route('admin.position.index')->with('message', 'Delete position success!');
    
    }
}
