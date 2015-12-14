@extends('admin.master')
@section('title')
Review
@endsection
@section('content')
@if(Auth::user()->id != $id)
    <div class="row">
        @if(Session::has('message'))
            <div id="message" class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Staff Info</h3>
                </div>
                <div class="panel-body">
                    @if(isset($staff) && !empty($staff))
                        <h4><label class="col-md-5">Name: </label><label class="col-md-5">{{ $staff->name }}</label></h4>
                        <h4><label class="col-md-5">Position: </label><label class="col-md-5">{{ isset($staff->position->name)?$staff->position->name:'None' }}</label>  </h4>
                        <h4><label class="col-md-5">Level: </label><label class="col-md-5">{{ $staff->level->name }}</label> </h4>
                        <h4><label class="col-md-5">Department: </label><label class="col-md-5"> {{ isset($staff->department->name)?$staff->department->name:'None'}}</label> </h4>
                        <h4><label class="col-md-5">Team: </label><label class="col-md-5"></label> </h4>
                    @endif
                </div>
            </div>
        </div>
    </div>




    <form name="frmReview" action="{{ route('admin.review.store') }}" method="POST">
        <div class="row">
            <div class="form-group form-group-sm">
                <label class="col-sm-2"></label>
                <div class="col-sm-8">
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
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="staffId" value="{{ isset($id)?$id:'' }}" >
        <div class="row">
            <div class="col-md-2">
                <label class="">
                    <p>
                        <span class="pull-left" style="padding-top:2px; padding-right:3px">Point : </span>
                        <input type="text" name="point" id="amount" readonly style=" color:#f6931f; font-weight:bold; width:25px; text-align:center">
                    </p>
                </label>
            </div>
            <div class="col-md-8">
                <div id="slider-range-min"></div> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"><label class=""><p><span class="pull-left" style="padding-top:2px; padding-right:3px">Review : </span></p></label></div>
            <div class="col-md-8">
                <textarea class="text-review" name="review"></textarea>
                <script type="text/javascript">ckeditor('review')</script>
            </div>

        </div>
        <div class="row">
            <div class="form-group form-group-sm">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-2">
                     Active <input type="radio" name="rActive" id="optionsRadios1" value="1" checked>
                </div>
                <div class="col-sm-2">
                     DeActive <input type="radio" name="rActive" id="optionsRadios1" value="0">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group form-group-sm" style="padding-top:20px">
                <label class="col-sm-2 control-label" for="formGroupInputSmall"></label>
                <div class="col-sm-6">
                    <button class="btn btn-primary" name="btnSubmit" style="width:100px">Create</button>
                </div>
            </div>
        </div>
    </form>
    <div class="row" style="height:200px">
        
    </div>
@endif
<div class="row">

    <div class="col-lg-12">
        


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
                                <th>Reviewer</th>
                                <th>Point</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($review as $review)
                                <tr class="odd gradeX">
                                    <td>{{ $review->staff->name?$review->staff->name:'' }}</td>
                                    <td>{{ $review->point }}</td>
                                    <td>{!! $review->comment !!}</td>
                                    <td class="center">
                                        <?php
                                            echo \Carbon\Carbon::createFromTimeStamp(strtotime($review["created_at"]))->diffForHumans()
                                        ?>
                                    </td>
                                    <td style="text-align:center">
                                        <label>
                                            <button class="btn btn-link"><a href="{{ route('admin.review.editReview', [$review->id, $staff->id]) }}"><i class="glyphicon glyphicon-pencil"></i></a></button> &nbsp;&nbsp;&nbsp;
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
 

<script>
  $(function() {
    $( "#slider-range-min" ).slider({
        range: "min",
        min: 0,
        max: 10,
        slide: function( event, ui ) {
            $( "#amount" ).val(ui.value );
        }
    });
    a = $( "#amount" ).val($( "#slider-range-min" ).slider( "value" ) );
  });
  </script>
@endsection