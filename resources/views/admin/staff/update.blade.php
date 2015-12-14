@extends('admin.master')
@section('title')
Edit Staff
@endsection
@section('content')
@if(Session::has('message'))
    <div id="message" class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif
<div class="form-group form-group-sm">
    <div class="col-sm-6">
        @if($check_account == 1)
            <a href="{{ route('admin.staff.getChange', Auth::user()->id) }}"><button class="btn btn-link">Change password</button></a>
        @endif
    </div>
</div>
<div class="row">
<form class="form-horizontal" method="POST" action="{{ route('admin.staff.update', $staff->id) }}">
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
        <label class="col-sm-2 control-label" for="formGroupInputSmall">Email</label>
        <div class="col-sm-6">
            <input class="form-control" name="txtEmail" type="text" value="{{ old('txtEmail',$staff->email?$staff->email:'')  }}" id="formGroupInputSmall" readonly >
        </div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Name</label>
    	<div class="col-sm-6">
      		<input class="form-control" name="txtName" type="text" id="formGroupInputSmall" value="{{ old('txtName',$staff->name?$staff->name:'')  }}">
    	</div>
    </div>
     <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label" for="formGroupInputSmall">Phone</label>
        <div class="col-sm-6">
            <input class="form-control" name="txtPhone" type="text" value="0{{ old('txtPhone',$staff->phone?$staff->phone:'')  }}" id="formGroupInputSmall" placeholder="Enter Phone Here ...">
        </div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Birth</label>
    	<div class="col-sm-6">
      		<input class="form-control" name="txtBirth" type="text" id="datepicker" id="formGroupInputSmall" value="{{ old('txtBirth',$staff->birthday?$staff->birthday:'')  }}" placeholder="Enter Birth Here ..." readonly style="background-color:#FFF" >
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Position</label>
    	<div class="col-sm-6">
      		<select class="form-control" name="position">
      		 	@if($position)
				    @foreach($position as $key => $value)
                        <?php 
                            isset($staff->position->id)?$position_id = $staff->position->id:$position_id =0;
                        ?>
				    	<option value="{{ $value['id'] }}" <?php echo ($value['id'] == $position_id)?'selected':''  ?> >{{ $value['name'] }}</option>
				    @endforeach
			    @endif
			</select>
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Level</label>
    	<div class="col-sm-6">
      		<select class="form-control" name="level">
			    @if($level)
				    @foreach($level as $key => $value)
				    	<option value="{{ $value['id'] }}" <?php echo ($value['id'] == $staff->level->id)?'selected':''  ?> >{{ $value['name'] }}</option>
				    @endforeach
			    @endif
			</select>
    	</div>
    </div>
    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall">Department</label>
    	<div class="col-sm-6">
      		<select class="form-control" name="department">
			    @if(isset($department) && !empty($department))
                    @can('check-admin')
                        @foreach($department as $key => $value)
                        <?php 
                            isset($staff->department->id)?$department_id = $staff->department->id:$department_id =0;
                        ?>
                            <option value="{{ $value['id'] }}" <?php echo ($value['id'] == $department_id)?'selected':''  ?> >{{ $value['name'] }}</option>
                        }
                        }
                        @endforeach
                    @endcan
                    @can('check-manager')
                        @foreach($department as $key => $value)
                            <?php
                                isset($staff->department->id)?$department_id = $staff->department->id:$department_id =0;
                            ?>  
                            <option value="{{ $value['id'] }}" <?php echo ($value['id'] == $department_id)?'selected':''  ?> >{{ $value['name'] }}</option>
                        @endforeach
                    @endcan
                    @can('check-leader')
                        <option value="{{ $department->id }}" <?php echo ($value['id'] == $staff->department->id)?'selected':''  ?> >  {{ $department->name }} </option>
                    @endcan
                    @can('check-developer')
                        <option value="{{ $department->id }}" <?php echo ($value['id'] == $staff->department->id)?'selected':''  ?> >  {{ $department->name }} </option>
                    @endcan
                @else
                    <option value="0" > ------  </option>
			    @endif
			</select>
    	</div>
    </div>
    <div class="form-group form-group-sm">
        <label class="col-sm-2 control-label"></label>
        <!--! yourself !-->
        @if($id == Auth::user()->id)
        @else
            @can('check-developer')
             @else
                <div class="col-sm-2">
                    Active <input type="radio" name="rActive" id="optionsRadios1" value="1" <?php echo ($staff->active==1)?'checked':'' ?> >
                </div>
                <div class="col-sm-2">
                     DeActive <input type="radio" name="rActive" id="optionsRadios1" value="0" <?php echo ($staff->active==0)?'checked':'' ?> >
                </div>
            @endcan
        @endif
    </div>

    <div class="form-group form-group-sm">
    	<label class="col-sm-2 control-label" for="formGroupInputSmall"></label>
    	<div class="col-sm-6">
      		<button class="btn btn-primary" name="btnSubmit" style="width:100px">Update</button>
    	</div>
    </div>
  
</form>
</div>
</div>
@endsection