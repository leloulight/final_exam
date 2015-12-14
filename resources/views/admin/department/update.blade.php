@extends('admin.master')
@section('title')
Create Department
@endsection
@section('content')
<form class="form-horizontal" method="POST" action="{{ route('admin.department.update', $department->id) }}">
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
      		<input class="form-control" name="txtName" type="text" id="formGroupInputSmall" value="{{ old('txtName',$department->name?$department->name:'')  }}">
    	</div>
    </div>
    
    
    
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-2">
             Active <input type="radio" name="rActive" id="optionsRadios1" value="1" <?php echo ($department->active==1)?'checked':'' ?> >
        </div>
        <div class="col-sm-2">
             DeActive <input type="radio" name="rActive" id="optionsRadios1" value="0" <?php echo ($department->active==0)?'checked':'' ?> >
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