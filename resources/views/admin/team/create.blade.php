@extends('admin.master')
@section('title')
Create Team
@endsection
@section('content')

<form class="form-horizontal" method="POST" action="{{ route('admin.team.store') }}">
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
      		<input class="form-control" name="txtName" type="text" value="{{ old('txtName') }}" placeholder="Enter Name Here ...">
    	</div>
    </div>
    
    
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall">Staff</label>
        <div class="col-sm-6">
            <select multiple="multiple" class="form-control" name="staff[]" id="staff">
                @foreach($staff as $key => $val)
                    <option value="{{ $val->id }}">  {{ $val->name }}  </option>
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
      		<button class="btn btn-primary" name="btnSubmit" style="width:100px">Create</button>
    	</div>
    </div>
  
</form>
@endsection