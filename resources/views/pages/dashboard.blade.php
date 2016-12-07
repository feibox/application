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
    <div class="row  no-margin-bottom">
        <div class="col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title">Recently uploaded files</div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                        @if($recents['files']->take(5)->count() > 0)
                            @include('includes.files-card', ['files' => $recents['files']->take(5)])
                        @else
                            Not enough data :(.
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title">Files uploaded by you</div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                        @if($user_files->count() > 0)
                            @include('includes.files-card', ['files' => $user_files])
                        @else
                            Not enough data :(.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title">Most popular files</div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                        @if($popular_files->count() > 0)
                            @include('includes.files-card', ['files' => $popular_files])
                        @else
                            Not enough data :(.
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title">Recent active colleagues</div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                        <div class="card-body">
                            @if($recents['colleagues']->count() > 0)
                                <table class="table table-hover rowlink" data-link="row">
                                <thead>
                                <tr>
                                    <th>ais id</th>
                                    <th>email</th>
                                    <th>user name</th>
                                    <th>options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recents['colleagues'] as $colleague)
                                    <tr>
                                        <td>{{ $colleague->ais_id or '-' }}</td>
                                        <td>{{ $colleague->email or '-' }}</td>
                                        <td>{{ $colleague->user_name or '-' }}</td>
                                        <td class="rowlink-skip">
                                            <a href="{{ route('colleagues.detail', ['id' => $colleague->id]) }}" class="btn btn-sm btn-default" alt="view" title="view"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                Not enough data :(.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop