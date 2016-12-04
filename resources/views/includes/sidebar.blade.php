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
                @can('view', \App\User::class)
                <li class="{{ set_active_routes('users.index') }}">
                    <a href="{{ route('users.index') }}">
                        <span class="icon fa fa-users"></span><span class="title">Users</span>
                    </a>
                </li>
                @endcan
                @can('view', \App\Subject::class)
                    <li class="{{ set_active_routes('subjects.index') }}">
                        <a href="{{ route('subjects.index') }}">
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