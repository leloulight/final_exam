<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Department;
use DOMPDF;
use Gate;
use App\StaffTeam;
use Auth;
use App\Team;
use App\Staff;
use Excel;
use App\Review;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff_team = '';
        $leader = '';
        $pie_leader= '';
        $department = '';
        
        $department = Department::leftJoin('staff', 'department.id', '=', 'staff.department_id')
                                ->join('level', 'staff.level_id', '=', 'level.id')
                                ->join('role', 'level.role_id', '=', 'role.id')
                                ->select(DB::raw('department.name as name_dep,role.name,count(*) as num'))
                                ->groupBy('department.name','role.name')
                                ->get()->toArray();
        $num_staff = $department;

        $pie = array();
        foreach ($department as $value) {
            $pie[$value['name_dep']][] = array($value['name'] , (int)$value['num']);
        }

        // is Leader
        if (Gate::allows('check-leader')) {
            $department = Department::leftJoin('staff', 'department.id', '=', 'staff.department_id')
                                ->join('level', 'staff.level_id', '=', 'level.id')
                                ->join('role', 'level.role_id', '=', 'role.id')
                                ->select(DB::raw('department.name as name_dep,role.name,count(*) as num'))
                                ->where(['department.id' => Auth::user()->department_id, 'department.active' => 1])
                                ->groupBy('department.name','role.name')
                                ->get()->toArray();
            $num_staff = $department;

            $pie = array();
            foreach ($department as $value) {
                $pie[$value['name_dep']][] = array($value['name'] , (int)$value['num']);
            }

        }
        

        // is Developer
        // if is manager / != department / yourself 
        // denied
        if (Gate::allows('check-developer')) {
            // get team of staff
            $staff = StaffTeam::where('staff_id', Auth::user()->id)->get()->first();
            if(isset($staff) && !empty($staff)){
                $staff_team = StaffTeam::where('team_id', $staff->team_id)->where('staff_id', '!=', Auth::user()->id)->get();
                $team = Team::where('id', $staff->team_id)->get()->first();
                $leader = Staff::find($team->creator);
            }
            // staff in department
            $staff_department = Staff::where(['active' => 1, 'department_id' => Auth::user()->department_id])->get();
           
        }                        
        return view('admin.department.home', compact('pie', 'staff_team', 'leader', 'num_staff', 'staff_department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listDep(){
        $dep = Department::all();
        return view('admin.department.list', compact('dep'));
    }
    public function create()
    {
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'txtName' => 'required',
            'rActive' => 'required|in:0,1',
        ]);
        $dep = New Department();
        $dep->name = $request->txtName;
        $dep->active = $request->rActive;
        $dep->save();

        return redirect()->route('admin.department.listDep')->with('message', 'Create Department success!');

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
        $department = Department::find($id);
        return view('admin.department.update', compact('department'));
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
        $this->validate($request,[
            'txtName' => 'required',
            'rActive' => 'required|in:0,1',
        ]);
        $dep = Department::find($id);
        $dep->name = $request->txtName;
        $dep->active = $request->rActive;
        $dep->save();

        return redirect()->route('admin.department.listDep')->with('message', 'Update Department success!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dep = Department::find($id);
        $dep->delete();
        return redirect()->route('admin.department.listDep')->with('message', 'Delete Department success!');

    }
    public function savePdf(){
        if (isset($_POST['htmlContent']) && $_POST['htmlContent'] != '')
        {
            if(Auth::user()->level->role->name == 'Manager'){
                $department = Department::leftJoin('staff', 'department.id', '=', 'staff.department_id')
                                ->join('level', 'staff.level_id', '=', 'level.id')
                                ->join('role', 'level.role_id', '=', 'role.id')
                                ->select(DB::raw('department.name as name_dep,role.name,count(*) as num'))
                                ->groupBy('department.name','role.name')
                                ->get()->toArray();
            }
            if(Auth::user()->level->role->name == 'TeamLeader'){
                $department = Department::leftJoin('staff', 'department.id', '=', 'staff.department_id')
                                    ->join('level', 'staff.level_id', '=', 'level.id')
                                    ->join('role', 'level.role_id', '=', 'role.id')
                                    ->select(DB::raw('department.name as name_dep,role.name,count(*) as num'))
                                    ->where(['department.id' => Auth::user()->department_id, 'department.active' => 1])
                                    ->groupBy('department.name','role.name')
                                    ->get()->toArray();
            }
            

            require_once 'public/dompdf/dompdf_config.inc.php';
         
            $file_name = 'Elisoft_Chart.pdf';

            $html = '<html>
                                <head>
                                    <style>
                                        img{
                                            width:335px;
                                            float:left;
                                            margin:10px;
                                        }
                                        .title{
                                            color:red;
                                            text-align: center;
                                            margin-bottom: 50px;
                                        }
                                        .table-staff{
                                            border: 2px;
                                            text-align:center;
                                        }
                                        .table-staff tr th{
                                            background-color: #DDD;
                                            padding: 5px 30px 5px 30px;
                                        }
                                        .table-staff tr td{
                                            padding: 5px 30px 5px 30px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <h1 class="title"> ELISOFT STAFF MANAGER </h1>
                                    <h3>1. Summary Chart</h3>
                                ';

            $html = $html.$_POST['htmlContent'];
            
            $html = $html.'
                                <h3>2. Table </h3>
                                    <table class="table-staff" border="1">
                                        <tr>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Quantity</th>
                                        </tr>
                                        
                                            ';
                                            foreach ($department as $key => $value) {
                                                $html = $html.'<tr><td>'.$value["name_dep"].'</td>';
                                                $html = $html.'<td>'.$value["name"].'</td>';
                                                $html = $html.'<td>'.$value["num"].'</td></tr>';
                                            }
            $html = $html.'                                
                                        
                                    </table>

                                

                                </body>
                            </html>';
                   
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $dompdf->stream($file_name);
        }
        else{
            echo 'fail!';
        }
    }

    public function saveExcel(){
        

        Excel::create('elisoft_staff', function($excel) {
            $excel->sheet('staff_manager', function($sheet) {
                $department = Department::leftJoin('staff', 'department.id', '=', 'staff.department_id')
                                ->join('level', 'staff.level_id', '=', 'level.id')
                                ->join('role', 'level.role_id', '=', 'role.id')
                                ->select(DB::raw('department.name as name_dep,role.name,count(*) as num'))
                                ->groupBy('department.name','role.name')
                                ->get()->toArray();
                $data = [];
                $arr = ['Department','Role','Quantity'];
                array_push($data, $arr);
                foreach ($department as $key => $value) {
                    $arr = [$value['name_dep'], $value['name'], $value['num']];
                    array_push($data, $arr);
                }

                                // Set font with ->setStyle()`
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  15,
                    )
                ));

                
                $sheet->fromArray($data);
            });
        })->export('xls');
    }
}
