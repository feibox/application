<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <span class="navbar-brand cursor-default" href="#">
                    <div class="icon fa fa-first-order"></div>
                    <div class="title">The FEIbox</div>
                </span>
                <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                    <i class="fa fa-times icon"></i>
                </button>
            </div>
            <ul class="nav navbar-nav">
                <li class="{{ set_active_routes('dashboard') }}">
                    <a href="{{ route('dashboard') }}">
                        <span class="icon fa fa-tachometer"></span><span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="{{ set_active_paths('colleagues*') }}">
                    <a href="{{ route('colleagues.index') }}">
                        <span class="icon fa fa-users"></span><span class="title">Colleagues</span>
                    </a>
                </li>
                @if(request()->segment(1) === 'courses' && count(request()->segments()) === 3)
                    <li class="panel panel-default dropdown {{ set_active_paths('courses/*') }}">
                        <a data-toggle="collapse" href="#dropdown-courses" class="{{ set_active_paths('courses/*', 'collapsed') }}">
                            <span class="icon fa fa-folder-open"></span><span class="title">Course - {{ $subject->code }}</span>
                        </a>
                        <div id="dropdown-courses" class="panel-collapse collapse {{ set_active_paths('courses/*', 'in') }}">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li class="{{ set_active_paths('courses/'.request()->segment(2).'/seminar', 'dropdown-active') }}">
                                        <a href="{{ url('courses/'.request()->segment(2).'/seminar') }}">
                                            <span class="icon fa fa-bell"></span><span class="title">Seminar</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active_paths('courses/'.request()->segment(2).'/exams', 'dropdown-active') }}">
                                        <a href="{{ url('courses/'.request()->segment(2).'/exams') }}">
                                            <span class="icon fa fa-pencil"></span><span class="title">Exams</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active_paths('courses/'.request()->segment(2).'/lectures', 'dropdown-active') }}">
                                        <a href="{{ url('courses/'.request()->segment(2).'/lectures') }}">
                                            <span class="icon fa fa-coffee"></span><span class="title">Lectures</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @else
                    <li class="{{ set_active_paths('courses*') }}">
                        <a href="{{ route('courses.index') }}">
                            <span class="icon fa fa-folder"></span><span class="title">Courses</span>
                        </a>
                    </li>
                @endif
                @can('view', \App\User::class)
                <li class="nav-divider"></li>
                <li class="{{ set_active_routes('users.index') }}">
                    <a href="{{ route('users.index') }}">
                        <span class="icon fa fa-users"></span><span class="title">Users</span>
                    </a>
                </li>
                @endcan
                @can('view', \App\Subject::class)
                    <li class="{{ set_active_paths(['subjects*']) }}">
                        <a href="{{ route('admin.subjects.index') }}">
                            <span class="icon fa fa-book"></span><span class="title">Subjects</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-divider"></li>
                <li class="panel panel-default dropdown {{ set_active_paths(['account/*', 'users/detail']) }}">
                    <a data-toggle="collapse" href="#dropdown-account" class="{{ set_active_paths(['account/*', 'users/detail'], 'collapsed') }}">
                        <span class="icon fa fa-id-card-o"></span><span class="title">Account</span>
                    </a>
                    <div id="dropdown-account" class="panel-collapse collapse {{ set_active_paths(['account/*', 'users/detail'], 'in') }}">
                        <div class="panel-body">
                            <ul class="nav navbar-nav">
                                <li class="{{ set_active_routes('users.detail', 'dropdown-active') }}">
                                    <a href="{{ route('users.detail') }}">
                                        <span class="icon fa fa-eye"></span><span class="title">Detail</span>
                                    </a>
                                </li>
                                <li class="{{ set_active_routes('account.password.edit', 'dropdown-active') }}">
                                    <a href="{{ route('account.password.edit') }}">
                                        <span class="icon fa fa-lock"></span><span class="title">Password</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}">
                                        <span class="icon fa fa-sign-out"></span><span class="title">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>