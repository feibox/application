@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">Colleague
                            <span class="description">{{ $colleague->full_name}}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="dl-horizontal">
                        <dt>ais id</dt>
                        <dd>{{ $colleague->ais_id }}</dd>
                        <dt>full name</dt>
                        <dd>{{ $colleague->titled_name }}</dd>
                        <dt>user name (stuba)</dt>
                        <dd>{{ $colleague->user_name }}</dd>
                        <dt>email</dt>
                        <dd>{{ $colleague->email }}</dd>
                        <dt>study information</dt>
                        <dd>{{ $colleague->study_information }}</dd>
                        <dt>updated at</dt>
                        <dd>{{ $colleague->updated_at }} ({{ $colleague->updated_at->diffForHumans() }})</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @include('includes.files', ['files' => $colleague->files])
    </div>
    <div class="row">
        @include('includes.go-back')
    </div>
@stop