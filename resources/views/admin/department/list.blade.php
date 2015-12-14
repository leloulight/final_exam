@extends('admin.master')
@section('title')
Level
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('message'))
            <div id="message" class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading danger">
                <p style="color:#337ab7">Department</p>
            </div>
            
            <!-- /.panel-heading -->
            <div class="row">
                <div class="col-sm-6" style="margin-top:10px; margin-left:10px">
                    
                 </div>
             </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped"  id="dataTables-example">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><a href="">Name </a></th>
                                <th style="text-align:center"><a href="">Status</a></th>
                                <th style="text-align:center"><a href="">Action</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt=1; ?>
                            @foreach($dep as $key => $value)
                                <tr>
                                    <td>{{ $stt }}</td>
                                    <td>{{ $value->name }}</td>
                                    <th><?php echo $value->active==1?'Active':'DeActive' ?></th>
                                    <td style="text-align:center">
                                        <label>
                                            <button class="btn btn-link"><a href="{{ route('admin.department.edit', $value->id) }}"><i class="glyphicon glyphicon-pencil"></i></a></button> &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <label>
                                            {!! Form::open( array( 'route' => array('admin.department.destroy',$value->id), 'method' => 'DELETE' ) ) !!}
                                                <button onclick="return deleteConfirm('You want delete?')" type="submit"  class="btn btn-link" ><i class="glyphicon glyphicon-remove"></i></button>
                                            {!! Form::close() !!}
                                        </label>
                                    </td>
                                </tr>
                                <?php $stt++ ?>
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
@endsection