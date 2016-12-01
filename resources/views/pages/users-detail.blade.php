@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">User
                            <span class="description">{{ $user_detail->full_name}}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="dl-horizontal">
                        <dt>status</dt>
                        <dd>
                            @if($user_detail->is_admin)
                                <span class="label label-primary">admin</span>
                            @endif
                            @if($user_detail->is_verified)
                                <span class="label label-success">verified</span>
                            @endif
                            @if($user_detail->is_valid)
                                <span class="label label-success">valid</span>
                            @endif
                            @if($user_detail->is_banned)
                                <span class="label label-danger">banned</span>
                            @endif
                            @if($user_detail->is_terminated)
                                <span class="label label-danger">terminated</span>
                            @endif
                        </dd>
                        <dt>full name</dt>
                        <dd>{{ $user_detail->titled_name }}</dd>
                        <dt>user name (stuba)</dt>
                        <dd>{{ $user_detail->user_name }}</dd>
                        <dt>email</dt>
                        <dd>{{ $user_detail->email }}</dd>
                        <dt>study information</dt>
                        <dd>{{ $user_detail->study_information }}</dd>
                        <dt>created at</dt>
                        <dd>{{ $user_detail->created_at }} ({{ $user_detail->created_at->diffForHumans() }})</dd>
                        <dt>updated at</dt>
                        <dd>{{ $user_detail->updated_at }} ({{ $user_detail->updated_at->diffForHumans() }})</dd>
                    </dl>
                </div>
            </div>
            @include('includes.go-back')
        </div>
    </div>
@stop