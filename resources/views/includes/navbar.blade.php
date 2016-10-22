<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-expand-toggle">
                <i class="fa fa-bars icon"></i>
            </button>
            @include('includes.breadcrumbs')
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-th icon"></i>
            </button>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-times icon"></i>
            </button>
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ $user->first_name }} <span class="caret"></span></a>
                <ul class="dropdown-menu animated fadeInDown">
                    <li class="profile-img">
                        <img src="https://dummyimage.com/600x400/000/fff" class="profile-img">
                    </li>
                    <li>
                        <div class="profile-info">
                            <h4 class="username">{{ $user->full_name }}</h4>
                            <p>{{ $user->email }}</p>
                            <div class="btn-group margin-bottom-2x" role="group">
                                <a href="{{ route('logout') }}" type="button" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>