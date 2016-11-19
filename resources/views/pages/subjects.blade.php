@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">Subjects
                            <span class="description">List of all ({{ $subjects->total() }}) subjects.</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($subjects->total() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>@sortablelink('id', 'id')</th>
                                <th>@sortablelink('code', 'code')</th>
                                <th>@sortablelink('name_en', 'name')</th>
                                <th>@sortablelink('study_level', 'study level')</th>
                                <th>@sortablelink('study_year', 'study year')</th>
                                <th>@sortablelink('created_at', 'created at')</th>
                                <th>@sortablelink('updated_at', 'updated at')</th>
                                <th>options</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->id }}</td>
                                        <td>
                                            <a href="http://is.stuba.sk/katalog/syllabus.pl?predmet={{ $subject->ais_id }};lang=en">
                                                {{ $subject->code or '-' }}
                                                </a>
                                        </td>
                                        <td>{{ $subject->name_en or '-' }}</td>
                                        <td>{{ $subject->study_level or '-' }}</td>
                                        <td>{{ $subject->study_year or '-' }}</td>
                                        <td>{{ $subject->created_at->diffForHumans() }}</td>
                                        <td>{{ $subject->updated_at->diffForHumans() }}</td>
                                        <td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $subjects->appends(\Request::except('page'))->render() !!}
                        </div>
                        <div class="sub-title">Legend</div>
                        <div>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-primary">
                                    <span class="badge">{{ $primaryCount or '0' }}</span> Account is validated and
                                    verified.
                                </li>
                                <li class="list-group-item list-group-item-info">
                                    <span class="badge">{{ $infoCount or '0' }}</span> Account is <strong>valid</strong>
                                    and not verified.
                                </li>
                                <li class="list-group-item list-group-item-warning">
                                    <span class="badge">{{ $warningCount or '0' }}</span> Account is
                                    <strong>neither</strong> validated nor verified.
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <span class="badge">{{ $dangerCount or '0' }}</span> Account is banned or
                                    terminated.
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