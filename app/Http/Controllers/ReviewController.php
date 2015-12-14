<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Staff;
use Input;
use Auth;
use App\Review;
use Carbon;
use Gate;
use App\StaffTeam;
use App\Team;

class ReviewController extends Controller
{

    public function __construct(){
        $this->middleware('review');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $staff_id = (int)$request->staffId;
        
        $staff = Staff::find($staff_id);
        // is Leader
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-leader')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Manager
        if (Gate::allows('check-manager')) {
            if($staff->level->role->name == 'Manager'){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Developer
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-developer')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id){
                return redirect()->route('admin.department.index');
            }

            // if != leader of team
            $staff_team = StaffTeam::where('staff_id', Auth::user()->id)->get()->first();
            if(!empty($staff_team)){
                $team = Team::where('id', $staff_team->team_id)->get()->first();
                if($staff->level->role->name == 'TeamLeader' && $staff->id != $team->creator){
                    return redirect()->route('admin.department.index');
                }   
            }
            // not of team
            else{
                return redirect()->route('admin.department.index');
            }
            
        }

        $this->validate($request, [
            'point' => 'required|numeric',
            'review' => 'required',
            'staffId' => 'required|numeric',
            'rActive' => 'required|numeric',
        ]);
        


        $review = ReView::where(['reviewer_id' => Auth::user()->id, 'staff_id' => $staff_id])->get()->first();
        

        // review less than 30 days!
        // denied
        if(isset($review) && !empty($review)){
            $time = strtotime($review->created_at);
            $curtime = time();

            if(($curtime-$time) < 3600*24*30) {
                return redirect()->route('admin.department.index')->with('message', 'less than 30 days!');
            }
            
        }
        $point = (int)$request->point;
        $reviewer = Auth::user()->id;
        $review = new Review();
        $review->staff_id = $staff_id;
        $review->reviewer_id = $reviewer;
        $review->point = $point;
        $review->comment = $request->review;
        $review->active = $request->rActive;
        $review->save();
        return redirect()->route('admin.review.show', $staff_id)->with('message', 'Create review complete!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $staff = Staff::find($id);
        // is Leader
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-leader')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Manager
        if (Gate::allows('check-manager')) {
            if($staff->level->role->name == 'Manager'){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Developer
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-developer')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id){
                return redirect()->route('admin.department.index')->with('message', 'Access is denied');
            }
        }
       
        if(isset($staff) && !empty($staff)){
            $review = Review::where('staff_id', $id)->get();
            return view('admin.review.create', compact('id', 'staff', 'review'));
        }    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'review' => 'required',
            'rActive' => 'required|in:0,1',
            'point' => 'required',
            'staffId' => 'required|numeric',
        ]);

        $staff_id = (int)$request->staffId;
        
        $staff = Staff::find($staff_id);

        $review = Review::find($id);

        // is Leader
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-leader')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id || $review->reviewer_id != Auth::user()->id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Manager
        if (Gate::allows('check-manager')) {
            if($staff->level->role->name == 'Manager'){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Developer
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-developer')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id || $review->reviewer_id != Auth::user()->id){
                return redirect()->route('admin.department.index')->with('message', 'Access is denied');
            }
        }

        
        $point = (int)$request->point;
        $reviewer = Auth::user()->id;
        
        $review->staff_id = $staff_id;
        $review->reviewer_id = $reviewer;
        $review->point = $point;
        $review->comment = $request->review;
        $review->active = $request->rActive;
        echo $staff_id;
        $review->save();
        return redirect()->route('admin.review.show', $staff_id)->with('message', 'Update review complete!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staffId = Input::get('staffId');
        $staff = Staff::find($staffId);

        $review = Review::find($id);

        if (Gate::allows('check-leader')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id || $review->reviewer_id != Auth::user()->id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Manager
        if (Gate::allows('check-manager')) {
            if($staff->level->role->name == 'Manager'){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Developer
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-developer')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id || $review->reviewer_id != Auth::user()->id){
                return redirect()->route('admin.department.index')->with('message', 'Access is denied');
            }
        }
        $review->delete();
        return redirect()->route('admin.review.show', $staffId)->with('message', 'Delete review complete!');
    }
    public function editReview($idReview= 0 , $idStaff = 0){
        $staff = Staff::find($idStaff);
        $review = Review::find($idReview);


        if (Gate::allows('check-leader')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id || $review->reviewer_id != Auth::user()->id){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Manager
        if (Gate::allows('check-manager')) {
            if($staff->level->role->name == 'Manager'){
                return redirect()->route('admin.staff.index')->with('message', 'Access is denied');
            }
        }

        // is Developer
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-developer')) {
            if($staff->level->role->name == 'Manager' || $staff->department_id != Auth::user()->department_id || $staff->id == Auth::user()->id || $review->reviewer_id != Auth::user()->id){
                return redirect()->route('admin.department.index')->with('message', 'Access is denied');
            }
        }

        return view('admin.review.update', compact('staff', 'review'));
        
    }

    function addColnum(){
        
    }
}
