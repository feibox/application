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
                                <th>@sortablelink('user_name', 'username')</th>
                                <th>@sortablelink('first_name', 'name')</th>
                                <th>@sortablelink('created_at', 'publish date')</th>
                                <th>@sortablelink('updated_at', 'last update')</th>
                                <th>options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $item)
                                @if($item->is_valid && $item->is_verified)
                                    <tr>
                                    @increment($primaryCount)
                                @elseif($item->is_valid && !$item->is_verified)
                                    <tr class="warning">
                                    @increment($warningCount) //
                                @elseif(!$item->is_valid && !$item->is_verified)
                                    <tr class="danger">
                                    @increment($dangerCount)
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
                                            <a href="#" class="btn btn-sm btn-default disabled">edit</a>
                                            <a href="{{ route('users.synchronize', ['email' => $item->email]) }}" class="btn btn-sm btn-default" alt="re-sync" title="synchronize user with stuba"><i class="fa fa-refresh"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger" alt="ban" title="ban user"><i class="fa fa-ban"></i></a>
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
                                    <span class="badge">{{ $primaryCount or '0' }}</span> User is validated and verified.
                                </li>
                                <li class="list-group-item list-group-item-warning">
                                    <span class="badge">{{ $warningCount or '0' }}</span> User is <strong>valid</strong> and not verified.
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <span class="badge">{{ $dangerCount or '0' }}</span> User is <strong>neither</strong> validated nor verified.
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