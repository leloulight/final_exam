@extends('admin.master')
@section('title')
Create Level
@endsection
@section('content')
<form class="form-horizontal" method="POST" action="{{ route('admin.level.update', $level->id) }}">
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
      		<input class="form-control" name="txtName" type="text" id="formGroupInputSmall" value="{{ old('txtName',$level->name?$level->name:'')  }}">
    	</div>
    </div>
    
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall">Role</label>
        <div class="col-sm-6">
            <select class="form-control" name="role">
                @if($role)
                    @foreach($role as $key => $value)
                        <option value="{{ $value['id'] }}" <?php echo ($value['id'] == $level->role->id)?'selected':''  ?> >{{ $value['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-2">
             Active <input type="radio" name="rActive" id="optionsRadios1" value="1" <?php echo ($level->active==1)?'checked':'' ?> >
        </div>
        <div class="col-sm-2">
             DeActive <input type="radio" name="rActive" id="optionsRadios1" value="0" <?php echo ($level->active==0)?'checked':'' ?> >
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