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
                        <table class="table table-hover rowlink" data-link="row">
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
                                @if($subject->is_valid && $subject->is_enabled)
                                    <tr>
                                    @increment($primaryCount)
                                @elseif($subject->is_valid && !$subject->is_enabled)
                                    <tr class="info rowlink-skip">
                                    @increment($infoCount)
                                @elseif(!$subject->is_valid && !$subject->is_enabled)
                                    <tr class="danger">
                                        @increment($dangerCount)
                                @endif
                                        <td>
                                            @can('browse', $subject)
                                                <a href="{{ route('subjects.folder', ['subject_id' => $subject->id]) }}">{{ $subject->id }}</a>
                                            @else
                                                <a href="#">{{ $subject->id }}</a>
                                            @endcan
                                        </td>
                                        <td class="rowlink-skip">
                                            <a href="http://is.stuba.sk/katalog/syllabus.pl?predmet={{ $subject->ais_id }};lang=en">
                                                <span class="label label-primary">
                                                    {{ $subject->code or '-' }}
                                                    <i class="fa fa-link"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td>{{ $subject->name_en or '-' }}</td>
                                        <td>{{ $subject->study_level or '-' }}</td>
                                        <td>{{ $subject->study_year or '-' }}</td>
                                        <td>{{ $subject->created_at->diffForHumans() }}</td>
                                        <td>{{ $subject->updated_at->diffForHumans() }}</td>
                                        <td class="rowlink-skip">
                                            <a href="#" class="btn btn-sm btn-default disabled" alt="re-sync" title="re-sync with STUBA">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            @if($subject->is_enabled)
                                                <a href="{{ route('subjects.disable', ['id' => $subject->id]) }}" class="btn btn-sm btn-danger enabled" alt="disable" title="disable">
                                                    <i class="fa fa-square-o"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('subjects.enable', ['id' => $subject->id]) }}" class="btn btn-sm btn-success {{$subject->study_year or 'disabled'}}" alt="enable" title="enable">
                                                    <i class="fa fa-check-square-o"></i>
                                                </a>
                                            @endif
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
                                    <span class="badge">{{ $primaryCount or '0' }}</span> Subject is validated and
                                    enabled.
                                </li>
                                <li class="list-group-item list-group-item-info">
                                    <span class="badge">{{ $infoCount or '0' }}</span> Subject is <strong>valid</strong>
                                    and not enabled.
                                </li>
                                <li class="list-group-item list-group-item-danger">
                                    <span class="badge">{{ $dangerCount or '0' }}</span> Subject is neither valid nor
                                    enabled.
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