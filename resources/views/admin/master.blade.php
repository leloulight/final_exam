@include('admin.inc.header')

            
@include('admin.inc.left')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('title')</h1>
                    
                </div>

                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->	
            @yield('content')
            
    
            </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('public/admin/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

    
    <!-- DataTables JavaScript -->
    <script src="{{ asset('public/admin/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('public/admin/dist/js/sb-admin-2.js') }}"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('public/admin/js/function.js') }}"></script>

    <!-- Button JavaScript -->

    <script src="https://cdn.datatables.net/buttons/1.1.0/js/dataTables.buttons.min.js"></script>
    
    <script src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.foundation.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.jqueryui.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.print.min.js"></script>
    
</body>

</html>
