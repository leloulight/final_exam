@extends('admin.master')
@section('title')
Change Password
@endsection
@section('content')
<form class="form-horizontal" method="POST" action="{{ route('admin.staff.postChange', Auth::user()->id) }}">
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
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Password Old:</label>
    	<div class="col-sm-6">
      		<input class="form-control" name="txtPassOld" type="password" id="formGroupInputSmall" value="{{ old('txtName') }}" placeholder="Enter Name Here ...">
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">New Password:</label>
    	<div class="col-sm-6">
      		<input class="form-control" name="txtPassNew" type="password" value="{{ old('txtEmail') }}" id="formGroupInputSmall" placeholder="Enter Email Here ...">
    	</div>
    </div>
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall"> Password Confirm:</label>
        <div class="col-sm-6">
            <input class="form-control" name="txtPassReNew" type="password" value="{{ old('txtEmail') }}" id="formGroupInputSmall" placeholder="Enter Email Here ...">
        </div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall"></label>
    	<div class="col-sm-6">
      		<button class="btn btn-primary" name="btnSubmit" style="width:100px">Update</button>
    	</div>
    </div>
  
</form>
@endsection