@extends('admin.master')
@section('title')
List Staff
@endsection
@section('content')

@can('check-admin')

<div class="row">
    <div class="col-lg-12">
        @if(Session::has('message'))
            <div id="message" class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <label>List Staff (Manager - Leader)</label>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Level</th>
                                <th>Department</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($staff as $staff)
                            @foreach($staff->staff as $value)
                                <tr class="odd gradeX">
                                    <td>{{ $value->name }}</td>
                                    <td>{{ isset($value->position->name)?$value->position->name:'None' }}</td>
                                    <td>{{ $value->level->name }}</td>
                                    <td>{{ isset($value->department->name)?$value->department->name:'None' }}</td>
                                    <th><?php echo $value->active==1?'Active':'DeActive' ?></th>
                                    <td style="text-align:center">
                                        <label>
                                            <button class="btn btn-link"><a href="{{ route('admin.staff.edit', $value->id) }}"><i class="glyphicon glyphicon-pencil"></i></a></button> &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <label>
                                            {!! Form::open( array( 'route' => array('admin.staff.destroy',$value->id), 'method' => 'DELETE' ) ) !!}
                                                <button onclick="return deleteConfirm('Bạn chắc chắn muốn xóa?')" type="submit"  class="btn btn-link" ><i class="glyphicon glyphicon-remove"></i></button>
                                            {!! Form::close() !!}
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

@else
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('message'))
            <div id="message" class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading danger">
                <p style="color:#337ab7">{{ $staff->total() }} Staffs / {{ $staff->lastPage() }} Pages</p>
            </div>
            <?php
                $sort=Request::input('sort');
                $qty = Request::input('show');
                $dep = Request::input('dep');
                $staff->appends('sort', $sort==1?2:1);
                $nameUrl = $staff->url($staff->currentPage());

                

                $staff->appends('sort', $sort);
                $nameImg = '';
                if($sort == 1)
                    $nameImg = "<i class='glyphicon glyphicon-triangle-bottom'></i>";
                if($sort == 2)
                    $nameImg = "<i class='glyphicon glyphicon-triangle-top'></i>";
            ?>
            <!-- /.panel-heading -->
            <div class="row">
                <div class="col-sm-4" style="margin-top:10px; padding-left:50px">
                    <form name="frmShow" action="{{ route('admin.staff.index') }}" method="GET">
                        <input name="dep" type="hidden" value="{{ $dep?$dep:'' }}">
                        <div class="dataTables_length">
                            <label>Show 
                                <select name="show" class="form-control" onchange="submitForm(this)">
                                    <option value="10" <?php echo $qty==10?'selected':'' ?> > 10 </option>
                                    <option value="25" <?php echo $qty==25?'selected':'' ?> > 25 </option>
                                    <option value="50" <?php echo $qty==50?'selected':'' ?> > 50 </option>
                                    <option value="100" <?php echo $qty==100?'selected':'' ?> > 100 </option>
                                </select>
                             entries</label>
                        </div>
                     </form>
                </div>
                @can('check-manager')
                <div class="col-sm-4" style="margin-top:10px">
                    <form name="frmShow" action="{{ route('admin.staff.index') }}" method="GET">
                        <input name="show" type="hidden" value="{{ $qty?$qty:'' }}">
                        <div class="dataTables_length">
                            <label>Department
                                <select name="dep" class="form-control" onchange="submitFormDepartment(this)" style="min-width:100px">
                                    <option value=" "> --------- </option>
                                    @foreach($department as $department)
                                        <?php
                                            echo '<option value="'.$department->id.'"';
                                            echo $dep==$department->id?'selected':'';
                                            echo '>'.$department->name.'</option>';
                                        ?>
                                    @endforeach
                                </select> 
                            </label>
                        </div>
                     </form>
                 </div>
                 @endcan
             </div>
        
            

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><a href="{{ $nameUrl }}">Name {!! $nameImg !!}</a></th>
                                <th><a href="{{ $nameUrl }}">Position {!! $nameImg !!}</a></th>
                                <th><a href="{{ $nameUrl }}">Level {!! $nameImg !!}</a></th>
                                <th><a href="{{ $nameUrl }}">Department {!! $nameImg !!}</a></th>
                                <th style="text-align:center">Average Score</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Action</th>
                                <th style="text-align:center">Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt=1; ?>
                            @foreach($staff as $key => $value)
                                <tr>
                                    <td>{{ $stt }}</td>
                                    <td><button class="btn btn-link tooltip-staff" data-toggle="tooltip" data-html="true" data-placement="top" title="Phone:0{{ $value->phone }} <br>  Email:{{ $value->email }}">{{ $value->name }}</button></td>
                                    <td>{{ isset($value->position->name)?$value->position->name:'None' }}</td>
                                    <td>{{ $value->level->name }}</td>
                                    <td>{{ isset($value->department->name)?$value->department->name:'None' }}</td>
                                    <td>{{ \App\Providers\AvgProvider::average($value->id)?\App\Providers\AvgProvider::average($value->id):'0' }}</td>
                                    <th><?php echo $value->active==1?'Active':'DeActive' ?></th>
                                    <td style="text-align:center">
                                        <label>
                                            <button class="btn btn-link"><a href="{{ route('admin.staff.edit', $value->id) }}"><i class="glyphicon glyphicon-pencil"></i></a></button> &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <label>
                                            {!! Form::open( array( 'route' => array('admin.staff.destroy',$value->id), 'method' => 'DELETE' ) ) !!}
                                                <button onclick="return deleteConfirm('You want delete?')" type="submit"  class="btn btn-link" ><i class="glyphicon glyphicon-remove"></i></button>
                                            {!! Form::close() !!}
                                        </label>
                                    </td>
                                    <td style="text-align:center">
                                        <label>
                                            <button class="btn btn-link"><a href="{{ route('admin.review.show', $value->id) }}"><i class="glyphicon glyphicon-saved"></i></a></button> &nbsp;&nbsp;&nbsp;
                                        </label>
                                    </td>
                                </tr>
                                <?php $stt++ ?>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="pull-right">
                        <nav>
                            <ul class="pagination">
                                @if( $staff->currentPage() > 1 )
                                    <li>
                                        <a href="{{ $staff->url(1) }}" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $staff->url($staff->currentPage()-4 ) }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif
                                @for($i = 1; $i <= $staff->lastPage(); $i++)
                                    @if($i <= $staff->currentPage()+3 && $i >= $staff->currentPage()-3)
                                        <li class="<?php echo $i==$staff->currentPage()?'active':'' ?>"><a href="{{ $staff->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endfor
                                @if($staff->currentPage()+3 < $staff->lastPage())
                                    <li>
                                        <a href="{{ $staff->url($staff->currentPage()+4 ) }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $staff->url($staff->lastPage()) }}" aria-label="Previous">
                                            <span aria-hidden="true">End</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    
                </div>
                <!-- /.table-responsive -->
                
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@endcan
@endsection