<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Level;
use App\Department;
use App\Position;
use App\Staff;
use App\Http\Requests\StaffCreateRequest;
use App\Http\Requests\UpdateStaffRequest;
use Mail;
use Hash;
use Gate;
use Auth;
use DB;
use Input;
use App\Review;
use App\StaffTeam;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort');
        $sort = max($sort, 1);
        $qty = $request->get('show');
        $qty = max($qty, 10);
        $dep = (int)$request->get('dep');
        $sorts = array(1=>['name' => 'asc'],['name' => 'desc']);
        $department = '';

        // is manager
        // show all staff 
        if (Gate::allows('check-manager')) {
            $staff = Staff::where('level_id', '!=', 6)->orderBy(key($sorts[$sort]), current($sorts[$sort]))
                        ->paginate($qty);
            if(isset($dep) && !empty($dep)){
                $staff = Staff::where('level_id', '!=', 6)->where('department_id', $dep)
                        ->orderBy(key($sorts[$sort]), current($sorts[$sort]))
                        ->paginate($qty);
            }      
            $department = Department::where('active', 1)->get();
        }
        // is leader
        // show staff in department 
        if(Gate::allows('check-leader')){
            $staff = Staff::where('level_id', '!=', 6)->where('department_id', Auth::user()->department_id)->orderBy(key($sorts[$sort]), current($sorts[$sort]))
                        ->paginate($qty);

        }
        // is admin
        // show all staff 
        if(Gate::allows('check-admin')){
            $staff = Level::where('active',1)->where('role_id', 2)->orWhere('role_id', 3)->get();
        }
        // is developer
        // denied
        if (Gate::allows('check-developer')) {
            return redirect()->route('admin.department.index');
        }
        
        if(Auth::user()->level->role_id == 2 || Auth::user()->level->role_id == 3){
            $staff->setPath('staff');
            $staff->appends('show',$qty);
            if(!empty($dep)){
                $staff->appends('dep',$dep);
            }
        }
        

        return view('admin.staff.list', compact('staff', 'department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = Position::where('active',1)->get();
        // is manager
        // create staff with role = Developer or Leader
        // department = all
        if (Gate::allows('check-manager')) {
            $level = Level::where(['role_id'=> 3, 'active' => 1])->orWhere(['role_id'=> 4, 'active' => 1])->get();
            $department = Department::where('active',1)->get();
        }
        // is leader
        // create staff with role = Developer
        // department = department leader
        else if(Gate::allows('check-leader')){
            $level = Level::where('role_id', 4)->where('active',1)->get();
            $department = Department::where('id', Auth::user()->department_id)->where('active',1)->get()->first();
        }
        // is admin
        // create staff with role = Manager or Leader
        // department = all
        else if(Gate::allows('check-admin')){
            $department = Department::where('active',1)->get();
            $level = Level::where(['role_id'=> 2, 'active' => 1])->orWhere(['role_id'=> 3, 'active' => 1])->get();
        }
        // is dev
        // denied
        else {
            return redirect()->route('admin.department.index');
        }
        
        return view('admin.staff.create', compact('level', 'department', 'position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffCreateRequest $request)
    {
        $position = $request->position;
        // is manager
        // department all
        if (Gate::allows('check-manager')) {
            $this->validate($request,[
                'department' => 'required|numeric',
            ]);
            $department = $request->department;
        }

        //is leader
        // department = department of leader
        else if(Gate::allows('check-leader')){
            $department = Auth::user()->department_id;
        }

        //is admin
        // department all
        else if(Gate::allows('check-admin')){
            $this->validate($request,[
                'department' => 'required|numeric|not_in:0',
            ]);
            $temp = (int)$request->level;
            $role = Level::find($temp);
            // is manager
            // department = 0
            // position = 0
            if($role->role_id == 2){
                $department = 0;
                $position = 0;
            }
            else{
                $department = $request->department;
            }
            
        }

        //is developer
        else {
            return redirect()->route('admin.department.index')->with('message', 'Access is Denied!');
        }

        $birth = date('Y-m-d', strtotime($request->txtBirth));
        $password = str_random(6);
        $staff = new Staff();
        $staff->name = $request->txtName;
        $staff->birthday = $birth;
        $staff->position_id = $position;
        $staff->level_id = $request->level;
        $staff->email = $request->txtEmail;
        $staff->password = Hash::make($password);
        $staff->phone = $request->txtPhone;
        $staff->department_id = $department;
        $staff->active = $request->rActive;
        $staff->save();

        Mail::send('emails.register', ['password' => $password], function ($m) use ($staff) {
            $m->from('tachikien2012@gmail.com', 'Elisoft Staff Manager');

            $m->to($staff->email)->subject('Your Password Register !');
        });

        return redirect()->route('admin.staff.index')->with('message', 'Add staff success!');
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
         
        $position = Position::where('active',1)->get();
        // if is Leader
        // if staff edit != dev or yourself => denied
        if(Gate::allows('check-leader')){
            $staff = Staff::find($id)->level->role;
            if($staff->name != "Developer" && $id != Auth::user()->id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }else{
                $level = Level::where('role_id', 4)->get();
                $department = Department::where('id', Auth::user()->department_id)->where('active', 1)->get()->first();
            }
        }
        //if is Admin
        // if staff = dev => denied
        else if(Gate::allows('check-admin')){
            $staff = Staff::find($id)->level->role;
            if($staff->name == "Developer" && $id != Auth::user()->id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
            else{
                $department = Department::where('active', 1)->get();
                $level = Level::where(['role_id'=> 2, 'active' => 1])->orWhere(['role_id'=> 3, 'active' => 1])->get();
            }
        }

        //is manager
        // if staff = manager => denied
        else if (Gate::allows('check-manager')) {
            $staff = Staff::find($id)->level->role;
            if($staff->name == "Manager" && $id != Auth::user()->id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
            else{
                $level = Level::where('role_id', 3)->orWhere('role_id', 4)->get();
                if($id == Auth::user()->id){
                    $department = '';
                }
                $department = Department::where('active', 1)->get();
            }

        }

        //is developer
        // only edit profile yourself
        else{
            $staff_id = Auth::user()->id;

            if($staff_id != $id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }else{
                $position = Position::where('id', Auth::user()->position_id)->where('active', 1)->get();
                $level = Level::where('id', Auth::user()->level_id)->where('active', 1)->get();
                $department = Department::where('id', Auth::user()->department_id)->where('active', 1)->get()->first();
            }
        }
        if($id == Auth::user()->id){
            $check_account = 1;
        }
        else{
            $check_account = 0;
        }

        
        $staff = Staff::find($id);
        return view('admin.staff.update', compact('id','staff', 'position', 'level', 'department', 'check_account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        $department = $request->department;
        $position = $request->position;
        $level = $request->level;

        //is manager
        if (Gate::allows('check-manager')) {
            $this->validate($request,[
                'department' => 'required|numeric|not_in:0',
            ]);
            if($id == Auth::user()->id){
                $department = 0;
            }
            else{
                $department = $request->department;
            }
            
        }

        //is leader
        else if(Gate::allows('check-leader')){
            $department = Auth::user()->department_id;
        }

        //is admin
        else if(Gate::allows('check-admin')){
            $this->validate($request,[
                'department' => 'required|numeric|not_in:0',
            ]);
            $temp1 = (int)$request->level;
            $role = Level::find($temp1);
            if($role->role_id == 2){
                $department = 0;
                $position = 0;
            }
            else{
                $department = $request->department;
            }
        }
        else{
            $department = Auth::user()->department_id;
            $position = Auth::user()->position_id;
            $level = Auth::user()->level_id;
        }
        if($id == Auth::user()->id){
            $department = Auth::user()->department_id;
            $position = Auth::user()->position_id;
            $level = Auth::user()->level_id;
            $request->rActive = 1;
        }

        $birth = date('Y-m-d', strtotime($request->txtBirth));
        $staff = Staff::find($id);
        $staff->name = $request->txtName;
        $staff->phone = $request->txtPhone;
        $staff->birthday = $birth;
        $staff->position_id = $position;
        $staff->level_id = $level;
        $staff->department_id = $department;
        $staff->active = $request->rActive;
        $staff->save();

        return redirect()->route('admin.staff.edit', $id)->with('message', 'Update profile success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::allows('check-leader')){
            $staff = Staff::find($id)->level->role;
            if($staff->name != "Developer"){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }
        if(Gate::allows('check-admin')){
            $staff = Staff::find($id)->level->role;
            if($staff->name == "Developer"){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }
        if(Gate::allows('check-developer')){
            return redirect()->route('admin.department.index')->with('message', 'Access is denied');
        }
        // if staff belongsto one team
        $findStaff = StaffTeam::where('staff_id', $id)->get()->toArray();
        if(!empty($findStaff)){
            return redirect()->route('admin.staff.index')->with('message', 'The staff belongto team !');
        }

        $staff = Staff::find($id);
        $staff->delete();
        // delete staff in review
        $staffReview = Review::where('reviewer_id', $id)->delete();
        $staffReview = Review::where('staff_id', $id)->delete();
        // delete staff in staff_team
        $staffReview = StaffTeam::where('staff_id', $id)->delete();
        return redirect()->route('admin.staff.index')->with('message', 'Delete staff complete !');
    }

    public function getChange($id){
        return view('admin.staff.change_password');
    }

    public function postChange(Request $request, $id){
        $this->validate($request, [
            'txtPassOld' => 'required',
            'txtPassNew' => 'required',
            'txtPassReNew' => 'required|same:txtPassNew',
        ]);

        $password = $request->txtPassOld;
        $newpass = $request->txtPassNew;
        if(Auth::attempt(['password' => $password, 'email' => Auth::user()->email])){
            DB::table('staff')
            ->where('id', Auth::user()->id)
            ->update(['password' => Hash::make($newpass)]);
            return redirect()->route('admin.staff.edit', $id)->with('message', 'Update password success');
        }
        else{
            return redirect()->route('admin.staff.edit', $id)->with('message', 'Update profile false');
        }
    }
}
