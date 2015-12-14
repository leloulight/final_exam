@extends('admin.master')
@section('title')
List Team
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
            <div class="panel-heading">
                <label>List Review</label>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Team Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($team as $team)
                                <tr class="odd gradeX">
                                    <td>{{ $team->name }}</td>
                                    <td>{{ $team->type }}</td>
                                    <td style="text-align:center">
                                        <label>
                                            <button class="btn btn-link"><a href="{{ route('admin.team.edit', $team->id) }}"><i class="glyphicon glyphicon-pencil"></i></a></button> &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <label>
                                            {!! Form::open( array( 'route' => array('admin.team.destroy',$team->id), 'method' => 'DELETE' ) ) !!}
                                                <button onclick="return deleteConfirm('You want delete?')" type="submit"  class="btn btn-link" ><i class="glyphicon glyphicon-remove"></i></button>
                                            {!! Form::close() !!}
                                        </label>
                                    </td>
                                </tr>
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