@extends('admin.master')
@section('title')
Update Team
@endsection
@section('content')

@if(Session::has('message'))
    <div id="message" class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif
<form class="form-horizontal" method="POST" action="{{ route('admin.team.update', $team->id) }}">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    <div class="form-group form-group-sm">
        <label class="col-sm-1"></label>
        <div class="col-sm-7">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall">Name</label>
        <div class="col-sm-6">
            <input class="form-control" name="txtName" type="text" value="{{ old('txtName',$team->name?$team->name:'')  }}" placeholder="Enter Name Here ...">
        </div>
    </div>

    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall">Staff</label>
        <div class="col-sm-6">

            <select multiple="multiple" class="form-control" name="staff[]" id="staff">
                @foreach($staff as $key => $val)
                    <?php
                        echo '<option value="'.$val->id.'"';
                        echo in_array($val->id, $staff_current)?'selected':'';
                        echo '> '.$val->name;
                        echo '</option>';
                    ?>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-2">
             Active <input type="radio" name="rActive" id="optionsRadios1" value="1" checked>
        </div>
        <div class="col-sm-2">
             DeActive <input type="radio" name="rActive" id="optionsRadios1" value="0">
        </div>
    </div>
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall"></label>
        <div class="col-sm-6">
            <button class="btn btn-primary" name="btnSubmit" style="width:100px">Update</button>
        </div>
    </div>
  
</form>

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
                        <th>Position</th>
                        <th>Review</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($team->staff as $value)
                        <tr class="odd gradeX">
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->position->name?$value->position->name:'None' }}</td>
                            <td style="text-align:center">
                                <label>
                                    <button class="btn btn-link"><a href="{{ route('admin.review.show', $value->id) }}"><i class="glyphicon glyphicon-saved"></i></a></button> &nbsp;&nbsp;&nbsp;
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
@endsection