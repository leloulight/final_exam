<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Level;
use App\Role;
use App\Staff;

class LevelController extends Controller
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
        $level = Level::where('role_id', '!=', 1)->get();
        $role = Role::where('name', '!=', 'SystemAdmin')->get();
        return view('admin.level.list', compact('level', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::where('active', 1)->get();
        return view ('admin.level.create', compact('role'));
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
            'txtName' => 'required', 'role' => 'required|numeric|not_in:0','rActive' => 'required|in:0,1',
        ]);

        $level = new Level();
        $level->name = $request->txtName;
        $level->role_id = $request->role;
        $level->active = $request->rActive;
        $level->save();
        return redirect()->route('admin.level.index')->with('message', 'Create level success!');

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
        $level = Level::find($id);
        $role = Role::where('name', '!=', 'SystemAdmin')->get();
        return view('admin.level.update', compact('level', 'role'));
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
            'role' => 'required|numeric|not_in:0',
            'rActive' => 'required|in:0,1',
        ]);

        $level = Level::find($id);
        $level->name = $request->txtName;
        $level->role_id = $request->role;
        $level->active = $request->rActive;
        $level->save();
        return redirect()->route('admin.level.index')->with('message', 'Update level success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findLevel = Staff::where('level_id', $id)->get()->toArray();
        if(!empty($findLevel)){
            return redirect()->route('admin.level.index')->with('message', 'Can\'t delete level !');
        }
        $level = Level::find($id);
        $level->delete();
        return redirect()->route('admin.level.index')->with('message', 'Delete level success!');
    }
}
