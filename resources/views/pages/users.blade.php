@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">Users
                            <span class="description">List of all ({{ $users->total() }})  users.</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($users->total() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>@sortablelink('id', 'id')</th>
                                <th>@sortablelink('ais_id', 'ais id')</th>
                                <th>@sortablelink('rank', 'rank')</th>
                                <th>@sortablelink('email', 'email')</th>
                                <th>@sortablelink('user_name', 'user name')</th>
                                <th>@sortablelink('first_name', 'full name')</th>
                                <th>@sortablelink('created_at', 'joined at')</th>
                                <th>@sortablelink('updated_at', 'updated at')</th>
                                <th>options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $item)
                                @if($item->is_terminated || $item->is_banned)
                                    <tr class="danger">
                                    @increment($dangerCount)
                                @elseif($item->is_valid && $item->is_verified)
                                    <tr>
                                    @increment($primaryCount)
                                @elseif($item->is_valid && !$item->is_verified)
                                    <tr class="info">
                                    @increment($infoCount)
                                @elseif(!$item->is_valid && !$item->is_verified)
                                    <tr class="warning">
                                    @increment($warningCount)
                                @endif
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->ais_id or '-' }}</td>
                                        <td>{{ $item->rank or '-' }}</td>
                                        <td>{{ $item->email or '-' }}</td>
                                        <td>{{ $item->user_name or '-' }}</td>
                                        <td>{{ $item->full_name or '-' }}</td>
                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                        <td>{{ $item->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('users.detail', ['id' => $item->id]) }}" class="btn btn-sm btn-default" alt="view" title="view"><i class="fa fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-default disabled">edit</a>
                                            <a href="{{ route('users.synchronize', ['id' => $item->id]) }}" class="btn btn-sm btn-default" alt="re-sync" title="synchronize user with stuba"><i class="fa fa-refresh"></i></a>
                                            @if($item->is_banned)
                                                <a href="{{ route('users.remove.ban', ['id' => $item->id]) }}" class="btn btn-sm btn-success" alt="remove ban" title="remove ban"><i class="fa fa-eraser"></i></a>
                                            @else
                                                <a href="{{ route('users.ban', ['id' => $item->id]) }}" class="btn btn-sm btn-danger" alt="ban" title="ban"><i class="fa fa-ban"></i></a>
                                            @endif

                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $users->appends(\Request::except('page'))->render() !!}
                        </div>
                        <div class="sub-title">Legend</div>
                        <div>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-primary">
                                    <span class="badge">{{ $primaryCount or '0' }}</span> Account is validated and verified.
                                </li>
                                <li class="list-group-item list-group-item-info">
                                    <span class="badge">{{ $infoCount or '0' }}</span> Account is <strong>valid</strong> and not verified.
                                </li>
                                <li class="list-group-item list-group-item-warning">
                                    <span class="badge">{{ $warningCount or '0' }}</span> Account is <strong>neither</strong> validated nor verified.
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <span class="badge">{{ $dangerCount or '0' }}</span> Account is banned or terminated.
                                </li>
                            </ul>
                        </div>
                    @else
                        Nothing interesting here :(.
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop