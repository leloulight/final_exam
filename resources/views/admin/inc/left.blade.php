<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="{{ route('admin.department.index') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        @can('check-manager')
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Staff<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.staff.create') }}">Create Staff</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.staff.index') }}">List Staff</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Team<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.team.create') }}">Create Team</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.team.index') }}">List Team</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endcan
                        @can('check-leader')
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Staff<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.staff.create') }}">Create Staff</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.staff.index') }}">List Staff</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Team<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.team.create') }}">Create Team</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.team.index') }}">List Team</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endcan
                        @can('check-admin')
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Staff<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.staff.create') }}">Create Staff</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.staff.index') }}">List Staff</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Level<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.level.create') }}">Create Level</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.level.index') }}">List Level</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Position<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.position.create') }}">Create Position</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.position.index') }}">List Position</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Department<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.department.create') }}">Create Department</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.department.listDep') }}">List Department</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('admin.review.show', Auth::user()->id) }}"><i class="fa fa-edit fa-fw"></i> Review</a>
                        </li>
                        
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>