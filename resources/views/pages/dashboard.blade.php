@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a href="{{ route('colleagues.index') }}">
                <div class="card red summary-inline">
                    <div class="card-body">
                        <i class="icon fa fa-users fa-4x"></i>
                        <div class="content">
                            <div class="title">{{ $counts['colleagues'] or '-' }}</div>
                            <div class="sub-title">Your Colleagues</div>
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a href="#">
                <div class="card yellow summary-inline">
                    <div class="card-body">
                        <i class="icon fa fa-files-o fa-4x"></i>
                        <div class="content">
                            <div class="title">{{ $counts['files'] or '-' }}</div>
                            <div class="sub-title">Total Files</div>
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a href="{{ route('courses.index') }}">
                <div class="card green summary-inline">
                    <div class="card-body">
                        <i class="icon fa fa-book fa-4x"></i>
                        <div class="content">
                            <div class="title">{{ $counts['courses'] or '-' }}</div>
                            <div class="sub-title">Total Courses</div>
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row no-margin-bottom">
asd
    </div>
@stop