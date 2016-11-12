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
                <li class="{{ set_active_routes('account.password.edit') }}">
                    <a href="{{ route('account.password.edit') }}">
                        <span class="icon fa fa-user"></span><span class="title">Password</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>