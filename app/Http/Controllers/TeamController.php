<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Team;
use App\Staff;
use App\StaffTeam;
use DB;
use Input;
use App\Department;
use Auth;
use Gate;

class TeamController extends Controller
{

    public function __construct()
    {
        $this->middleware('team');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = Team::all();
        return view('admin.team.list', compact('team'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // is manager
        // show staff is leader and manager
        if (Gate::allows('check-manager')) {
            $staff  = DB::table('staff')->leftJoin('level', 'staff.level_id', '=', 'level.id')
                                    ->join('role', 'level.role_id', '=', 'role.id')
                                    ->select('staff.*')
                                    ->where('staff.id', '!=', Auth::user()->id)
                                    ->where(['role.name'=> 'Manager', 'staff.active' => 1])
                                    ->orWhere(['role.name'=> 'TeamLeader', 'staff.active' => 1])
                                    ->get(); 
        }
        // is leader
        // show staff is developer
        if(Gate::allows('check-leader')){
           $staff  = DB::table('staff')->leftJoin('level', 'staff.level_id', '=', 'level.id')
                                    ->join('role', 'level.role_id', '=', 'role.id')
                                    ->join('department', 'staff.department_id', '=', 'department.id')
                                    ->select('staff.*')
                                    ->where(['role.name'=> 'Developer', 'staff.active' => 1, 'department.id' => Auth::user()->department_id])
                                    ->where('staff.id', '!=', Auth::user()->id)
                                    ->get(); 
        }
        return view('admin.team.create', compact('staff'));
        
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
            'staff' => 'required',
            'rActive' => 'required|in:0,1',
        ]);

        $team = new Team();

        // is manager
        // insert team type Manager
        if (Gate::allows('check-manager')) {
           $team->type = 'Manager';
        }
        // is leader
        // insert team type Leader
        if(Gate::allows('check-leader')){
            $team->type = 'Leader';
        }
        $team->active = $request->rActive;
        $team->name = $request->txtName;
        $team->creator = Auth::user()->id;
        $team->save();

        foreach ($request->staff as $value) {
            $staffTeam = new StaffTeam();
            $staffTeam->staff_id = $value;
            $staffTeam->team_id = $team->id;
            $staffTeam->save();
        }

        return redirect()->route('admin.team.index')->with('message', 'Create team success!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::find($id);
        // is not creator
        // denied
        if(Gate::denies('update-team', $team)){
            return redirect()->route('admin.team.index')->with('message', 'Access denied !'); 
        }
        // is manager
        // show staff is leader and manager
        if (Gate::allows('check-manager')) {
            $staff  = DB::table('staff')->leftJoin('level', 'staff.level_id', '=', 'level.id')
                                    ->join('role', 'level.role_id', '=', 'role.id')
                                    ->select('staff.*')
                                    ->where('staff.id', '!=', Auth::user()->id)
                                    ->where(['role.name'=> 'Manager', 'staff.active' => 1])
                                    ->orWhere(['role.name'=> 'TeamLeader', 'staff.active' => 1])
                                    ->get(); 
        }
        // is leader
        // show staff is developer
        if(Gate::allows('check-leader')){
           $staff  = DB::table('staff')->leftJoin('level', 'staff.level_id', '=', 'level.id')
                                    ->join('role', 'level.role_id', '=', 'role.id')
                                    ->join('department', 'staff.department_id', '=', 'department.id')
                                    ->select('staff.*')
                                    ->where(['role.name'=> 'Developer', 'staff.active' => 1, 'department.id' => Auth::user()->department_id])
                                    ->where('staff.id', '!=', Auth::user()->id)
                                    ->get(); 
        }
        $staff_current = array();
        foreach ($team->staff as $key => $value) {
            $staff_current[] = $value->id;
        }
        return view('admin.team.update', compact('team', 'staff','staff_current'));
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
            'staff' => 'required',
            'rActive' => 'required|in:0,1',
        ]);

        $team = Team::find($id);

        // is manager
        // insert team type Manager
        if (Gate::allows('check-manager')) {
           $team->type = 'Manager';
        }
        // is leader
        // insert team type Leader
        if(Gate::allows('check-leader')){
            $team->type = 'Leader';
        }
        $team->active = $request->rActive;
        $team->name = $request->txtName;
        $team->creator = Auth::user()->id;
        $team->save();

        // if not exists staff in new array staff
        // delete staff in team  
        $sta = StaffTeam::where('team_id', $id)->get();
        foreach ($sta as $key => $value) {
            if(!in_array($value->staff_id, $request->staff)){
                StaffTeam::where(['team_id' => $team->id, 'staff_id' => $value->staff_id])->delete();
            }
        }

        // if not exists staff  staff_team
        // create staff in team 
        foreach ($request->staff as $val) {
            $temp = StaffTeam::where(['team_id' => $team->id,'staff_id'=> $val])->get()->toArray();
            if(empty($temp)){
                $staffTeam = new StaffTeam();
                $staffTeam->staff_id = $val;
                $staffTeam->team_id = $team->id;
                $staffTeam->save();
            }
                
        }

        return redirect()->route('admin.team.edit', $id)->with('message', 'Update team success!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        // is not creator
        // denied
        if(Gate::denies('update-team', $team)){
            return redirect()->route('admin.team.index')->with('message', 'Access denied !'); 
        }
        $team->delete();
        $staff_team = StaffTeam::where('team_id', $id)->get();
        foreach ($staff_team as $key => $value) {
            StaffTeam::where(['team_id' => $id, 'staff_id' => $value->staff_id])->delete();
        }
        return redirect()->route('admin.team.index')->with('message', 'Delete success !'); 
    }
    
}
