<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Elisoft - Staff manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('public/admin/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{ asset('public/admin/dist/css/timeline.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('public/admin/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    
    <!-- DataTables CSS -->
    <link href="{{ asset('public/admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('public/admin/bower_components/datatables-responsive/css/dataTables.responsive.css') }}" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="{{ asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Processbar CSS -->
    <link href="{{ asset('public/admin/css/bootstrap-progressbar-3.3.4.css') }}" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="{{ asset('public/admin/css/style.css') }}" rel="stylesheet">


    <!-- Jquery UI  -->
    <!-- jQuery -->
    <script src="{{ asset('public/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <link href="{{ asset('public/admin/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('public/admin/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
      $(function() {
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy",
            yearRange: "1970:2030"
        });
      });
    </script>

    <!-- Button Jquery -->
    
    <link href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.jqueryui.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.foundation.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.jqueryui.min.css" rel="stylesheet">

    <!-- SUMO Jquery -->
    <link href="{{ asset('public/admin/sumo/sumoselect.css') }}" rel="stylesheet">
    <script src="{{ asset('public/admin/sumo/jquery.sumoselect.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- CK editor && CK finder -->
    <script type="text/javascript" src="{{ asset('public/admin/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/js/ckfinder/ckfinder.js') }}"></script>
    <script type="text/javascript">
        var baseURL = "{{ url('/') }}";
    </script>
    <script type="text/javascript" src="{{ asset('public/admin/js/func_ckfinder.js') }}"></script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('admin.review.show', Auth::user()->id) }}">Staff Manager | Hello {{ Auth::user()->name }} ({{ $role }})</a> 
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('admin.staff.edit', Auth::user()->id) }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('auth/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->