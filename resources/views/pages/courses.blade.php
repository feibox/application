@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">Courses
                            <span class="description">List of all ({{ $courses->total() }}) subjects.</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($courses->total() > 0)
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
                            @foreach($courses as $course)
                                <tr>
                                    <td><a href="{{ route('courses.folder', ['subject_id' => $course->id]) }}">{{ $course->id }}</a></td>
                                    <td class="rowlink-skip">
                                        <a href="http://is.stuba.sk/katalog/syllabus.pl?predmet={{ $course->ais_id }};lang=en">
                                            <span class="label label-primary">
                                                {{ $course->code or '-' }}
                                                <i class="fa fa-link"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td>{{ $course->name_en or '-' }}</td>
                                    <td>{{ $course->study_level or '-' }}</td>
                                    <td>{{ $course->study_year or '-' }}</td>
                                    <td>{{ $course->created_at->diffForHumans() }}</td>
                                    <td>{{ $course->updated_at->diffForHumans() }}</td>
                                    <td class="rowlink-skip">
                                        <a href="{{ route('courses.folder', ['subject_id' => $course->id]) }}" class="btn btn-sm btn-default" alt="open" title="open course">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $courses->appends(\Request::except('page'))->render() !!}
                        </div>
                    @else
                        Nothing interesting here :(.
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop