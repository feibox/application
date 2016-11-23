@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">
                            Folders for subject
                            <a href="http://is.stuba.sk/katalog/syllabus.pl?predmet={{ $subject->ais_id }};lang=en">
                                <span class="label label-primary">
                                    {{ $subject->code or '-' }}
                                    <i class="fa fa-link"></i>
                                </span>
                            </a>
                            <span class="description">
                            @if(is_null($current_folder))
                                    root
                                @else
                                    {{ $current_folder->name }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($folders->count() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Folder name</th>
                                <th>Created by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($folders as $folder)
                                <tr>
                                    <td>
                                        <a href="{{ route('subject.folder', ['subject_id' => $subject->id, 'folder' => $folder_prefix . $folder->name]) }}">{{ $folder->name}}</a>
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>{{ $folder->created_at->diffForHumans() }}</td>
                                    <td>{{ $folder->updated_at->diffForHumans() }}</td>
                                    <td>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        @if(is_null($current_folder))
                            Nothing interesting here :(. Want to create a <a class="btn-link"
                                                                             href="{{ route('subject.folder.create', ['subject_id' => $subject->id]) }}">folder</a>
                            ?
                        @else
                            Nothing interesting here :(. Want to create a <a class="btn-link"
                                                                             href="{{ route('subject.folder.specific.create', ['subject_id' => $subject->id, 'folder' => $current_folder->name]) }}">folder</a>
                            ?
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @if(!is_null($current_folder))
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">
                                files
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($current_folder->files->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>File name</th>
                                    <th>Uploaded by</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($current_folder->files as $file)
                                    <tr>
                                        <td>
                                            <a href="#">{{ $file->original_filename}}</a>
                                        </td>
                                        <td> - </td>
                                        <td>{{ $file->created_at->diffForHumans() }}</td>
                                        <td>{{ $file->updated_at->diffForHumans() }}</td>
                                        <td>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            Nothing interesting here :(. Want to upload a <a href="#">file</a>?
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">
                                File Upload drop-zone will come here
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('file.upload', ['subject_id' => $subject->id, 'folder' => $current_folder->name]) }}" method="post"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="folder_id" value="{{ $current_folder->id }}">
                            <input type="file" name="uploading_file">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-sm-12">
            <a href="{{ url()->previous() }}" class="btn btn-default full-width" role="button"><i
                        class="fa fa-arrow-left"></i> go back</a>
        </div>
    </div>
@stop