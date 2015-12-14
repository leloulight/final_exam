@extends('admin.master')
@section('title')
Create Staff
@endsection
@section('content')
<form class="form-horizontal" method="POST" action="{{ route('admin.staff.store') }}">
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
      		<input class="form-control" name="txtName" type="text" id="formGroupInputSmall" value="{{ old('txtName') }}" placeholder="Enter Name Here ...">
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Email</label>
    	<div class="col-sm-6">
      		<input class="form-control" name="txtEmail" type="text" value="{{ old('txtEmail') }}" id="formGroupInputSmall" placeholder="Enter Email Here ...">
    	</div>
    </div>
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall">Phone</label>
        <div class="col-sm-6">
            <input class="form-control" name="txtPhone" type="text" value="{{ old('txtPhone') }}" id="formGroupInputSmall" placeholder="Enter Email Here ...">
        </div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Birth</label>
    	<div class="col-sm-6">
      		<input class="form-control" name="txtBirth" type="text" id="datepicker" id="formGroupInputSmall" value="{{ old('txtBirth') }}" placeholder="Enter Birth Here ..." readonly style="background-color:#FFF" >
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Position</label>
    	<div class="col-sm-6">
      		<select class="form-control" name="position">
      		 	<option value="0">  ------  </option>
			    @if($position)
				    @foreach($position as $key => $value)
				    	<?php echo '<option value="'.$value['id'].'" > '.$value['name'].' </option>' ?>
				    @endforeach
			    @endif
			</select>
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Level</label>
    	<div class="col-sm-6">
      		<select class="form-control" name="level">
			    <option value="0">  ------  </option>
			    @if($level)
				    @foreach($level as $key => $value)
				    	<?php echo '<option value="'.$value['id'].'" > '.$value['name'].' </option>' ?>
				    @endforeach
			    @endif
			</select>
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Department</label>
    	<div class="col-sm-6">
      		<select class="form-control" name="department">
			    <option value="0">  ----- </option>
			    @if($department)
                    @can('check-admin')
                        @foreach($department as $key => $value)
                            <?php echo '<option value="'.$value['id'].'" > '.$value['name'].' </option>' ?>
                        @endforeach
                    @endcan
                    @can('check-manager')
    				    @foreach($department as $key => $value)
    				    	<?php echo '<option value="'.$value['id'].'" > '.$value['name'].' </option>' ?>
    				    @endforeach
                    @endcan
                    @can('check-leader')
                        <option value="{{ $department->id }}">  {{ $department->name }} </option>
                    @endcan
			    @endif
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
      		<button class="btn btn-primary" name="btnSubmit" style="width:100px">Create</button>
    	</div>
    </div>
  
</form>
@endsection