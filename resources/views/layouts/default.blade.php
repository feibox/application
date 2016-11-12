<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="flat-blue">
<div class="app-container expanded">
    <div class="row content-container">
        @include('includes.navbar')
        @include('includes.sidebar')
        <div class="container-fluid">
            <div class="side-body padding-top">
                @notification()
                @yield('content')
            </div>
        </div>
    </div>
    <footer class="app-footer">
        <div class="wrapper">
            Made with <i class="fa fa-heart text-danger"></i>.
            <span class="pull-right">v 0.1</span>
        </div>
    </footer>
@include('includes.scripts')
</body>
</html>