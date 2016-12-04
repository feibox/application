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
            <div class="card-body">
                @if($colleagues->total() > 0)
                <table class="table table-hover rowlink" data-link="row">
                    <thead>
                    <tr>
                        <th>@sortablelink('ais_id', 'ais id')</th>
                        <th>@sortablelink('email', 'email')</th>
                        <th>@sortablelink('user_name', 'user name')</th>
                        <th>@sortablelink('first_name', 'full name')</th>
                        <th>@sortablelink('file_count', 'file count')</th>
                        <th>@sortablelink('updated_at', 'updated at')</th>
                        <th>options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colleagues as $item)
                    <tr>
                        <td>{{ $item->ais_id or '-' }}</td>
                        <td>{{ $item->email or '-' }}</td>
                        <td>{{ $item->user_name or '-' }}</td>
                        <td>{{ $item->full_name or '-' }}</td>
                        <td>{{ $item->files->first()->file_count or '-' }}</td>
                        <td>{{ $item->updated_at->diffForHumans() }}</td>
                        <td class="rowlink-skip">
                            <a href="{{ route('colleagues.detail', ['id' => $item->id]) }}" class="btn btn-sm btn-default" alt="view" title="view"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {!! $colleagues->appends(\Request::except('page'))->render() !!}
                </div>
                @else
                Nothing interesting here :(.
                @endif
            </div>
        </div>
    </div>
</div>
@stop