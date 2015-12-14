@extends('admin.master')
@section('title')
DashBoard
@endsection
@section('content')
@if(Session::has('message'))
    <div id="message" class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif


@can('check-developer')
	<div class="row">
	    <div class="col-lg-12">
	        <div class="alert alert-success">
                <label>Average score : {{ \App\Providers\AvgProvider::average(Auth::user()->id)?\App\Providers\AvgProvider::average(Auth::user()->id):'0' }}</label>
            </div>
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <label>List Staff Team</label>
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	                <div class="dataTable_wrapper">
	                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                        <thead>
	                            <tr>
	                                <th>Name</th>
	                                <th> Average score </th>
	                                <th>Level</th>
	                                <th>Review</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@if(isset($leader) && !empty($leader))
	                        		<tr>
		                        		<td class="leader">&nbsp;<a href="javascript:void(0)" style="color:red;" class="btn btn-link tooltip-staff" data-toggle="tooltip" data-html="true" data-placement="top" title="Phone:0{{ $leader->phone }} <br>  Email:{{ $leader->email }}">{{ $leader->name }} (BOSS)</a></td>
		                        		<td style="text-align:center">{{ \App\Providers\AvgProvider::average($leader->id)?\App\Providers\AvgProvider::average($leader->id):'0' }}</td>
		                        		<td>{{ $leader->level->name }}</td>
		                        		<td style="text-align:center">
		                                   	<label>
		                                   		<button class="btn btn-link"><a href="{{ route('admin.review.show', $leader->id) }}"><i class="fa fa-thumbs-up"></i></a></button> &nbsp;&nbsp;&nbsp;
		                                    </label>
		                                </td>
		                        	</tr>
	                        	@endif
	                            @if(isset($staff_team) && !empty($staff_team))
	                            	@foreach($staff_team as $staff_team)
		                                <tr class="odd gradeX">
		                                	<td><button class="btn btn-link tooltip-staff" data-toggle="tooltip" data-html="true" data-placement="top" title="Phone:0{{ $staff_team->staff->phone }} <br>  Email:{{ $staff_team->staff->email }}">{{ $staff_team->staff->name }}</button></td>
		                                    <td style="text-align:center">{{ \App\Providers\AvgProvider::average($staff_team->staff->id)?\App\Providers\AvgProvider::average($staff_team->staff->id):'0' }}</td>
		                                    <td>{{ $staff_team->staff->level->name }}</td>
		                                    <td style="text-align:center">
		                                       	<label>
		                                            <button class="btn btn-link"><a href="{{ route('admin.review.show', $staff_team->staff->id) }}"><i class="fa fa-thumbs-up"></i></a></button> &nbsp;&nbsp;&nbsp;
		                                        </label>
		                                    </td>
		                                </tr>
		                            @endforeach
	                            @endif
	                        </tbody>
	                    </table>
	                </div>
	                <!-- /.table-responsive -->
	            </div>
	            <!-- /.panel-body -->
	        </div>
	        <!-- /.panel -->

	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <label>Other Staff In Department</label>
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	                <div class="dataTable_wrapper">
	                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                        <thead>
	                            <tr>
	                                <th>Name</th>
	                                <th>Level</th>
	                                <th>Review</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@if(isset($staff_department) && !empty($staff_department))
	                        	<?php  ?>
	                            	@foreach($staff_department as $staff_department)
		                                <tr class="odd gradeX">
		                                	<td><button class="btn btn-link tooltip-staff" data-toggle="tooltip" data-html="true" data-placement="top" title="Phone:0{{ $staff_department->phone }} <br>  Email:{{ $staff_department->email }}">{{ $staff_department->name }}</button></td>
		                                    <td>{{ $staff_department->level->name }}</td>
		                                    <td style="text-align:center">
		                                       	<label>
		                                            <button class="btn btn-link"><a href="{{ route('admin.review.show', $staff_department->id) }}"><i class="fa fa-thumbs-up"></i></a></button> &nbsp;&nbsp;&nbsp;
		                                        </label>
		                                    </td>
		                                </tr>
		                            @endforeach
	                            @endif
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


@else

<div class="panel panel-default">
    <div class="panel-heading">
        <label>Number Staff In Department</label>
    </div>
    @if(Auth::user()->level->role_id == 2 || Auth::user()->level->role_id == 3 )
	    <div class="export pull-right">
		    <form method='post' action="{{ route('savePdf') }}" id='savePDFForm'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			 	<input type='hidden' id='htmlContentHidden' name='htmlContent' value='htmlContentHidden'>
			 	<a href="{{ route('saveExcel') }}"><input type='button' class="btn btn-default" id="save-excel" value='Save to Excel'></a>
			 	<input type='button' class="btn btn-default" id="downloadBtn" value='Save to PDF'>
			</form>
		</div>
	@endif
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Number</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($num_staff as $num)
	                    <tr>
	                    	<td>{{ $num['name_dep'] }}</td>
	                    	<td>{{ $num['name'] }}</td>
	                    	<td>{{ $num['num'] }}</td>
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


<div class="row">
<?php
	$stt = 0;
	$pie_2 = array();
	foreach ($pie as $key => $pie_chart) {
		$pie_2 = $pie_chart;
		$stt++;
		$pie_chart = json_encode($pie_chart);
   		
        $HTML =<<<XYZ
        <script type="text/javascript">
	      	google.load("visualization", "1", {packages:["corechart"]});
	      	google.setOnLoadCallback(drawChart);
	      	function drawChart() {
		        var data = new google.visualization.DataTable();
		          	data.addColumn('string', 'Age Range');
		          	data.addColumn('number', 'Number');
		          	data.addRows({$pie_chart});
	        

		        var options = {
		          	title: "$key",
		          	is3D: true,
		          	backgroundColor: '#CCC',
		          	width: 500,
        			height: 400,
        			fontSize: 16,
        			titleTextStyle:{ 
        				color: 'red',
        				fontSize: 20,
					},
					chartArea:{left:30,top:30,width:'80%',height:'80%'}
		          	
		        };

		        // Instantiate and draw our chart, passing in some options.
		        var chart_div = document.getElementById('$stt');
		        var chart = new google.visualization.PieChart(chart_div);
		 		
		        var chart_div_final = document.getElementById('a$stt');
		        var chart_final = new google.visualization.PieChart(chart_div_final);
		        // Wait for the chart to finish drawing before calling the getIm geURI() method.
		        google.visualization.events.addListener(chart, 'ready', function () {
		         chart_div_final.innerHTML = '<img src="' + chart.getImageURI() + '">';
		        });

		        chart.draw(data, options);
		        
		    }
	      	// Make the charts responsive
		    jQuery(document).ready(function(){
		        jQuery(window).resize(function(){
		          	drawChart();
		        });
		    });
	    </script>

		<div id="$stt" style="float:left !important; border:2px solid #AEA; border-radius:5px; margin:10px"></div>
		<div id="a$stt" style="display:none"></div>

XYZ;
echo $HTML;

}
?>
</div>
<?php
	// push image
	echo '<script>
	jQuery(document).ready(function() {
	    jQuery("#downloadBtn").on("click", function() {
	    	var htmlContent = "";
	    ';

	    for($i = 1; $i <= $stt; $i++){
	    	echo 'var htmlContent'.$i.' = jQuery("#a'.$i.'").html();';
	    	echo 'htmlContent = htmlContent + htmlContent'.$i.';';
		}

	    echo 'jQuery("#htmlContentHidden").val(htmlContent);
				
	        // submit the form
	        jQuery("#savePDFForm").submit();
	    });
	  });
	</script>';
	
	
?>

@endcan







@endsection