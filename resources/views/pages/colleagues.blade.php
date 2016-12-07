@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Colleagues
                        <span class="description">List of your all ({{ $colleagues->total() }}) colleagues.</span>
                    </div>
                </div>
            </div>
            @include('includes.colleagues-card', ['colleagues' => $colleagues])
        </div>
    </div>
</div>
@stop