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
                                        {{ $folder->user->user_name }}
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

                    @endif
                    <div class="sub-title">Create folder</div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap!</strong> Change a few things up and try submitting again.
                        </div>
                    @endif
                    <form action="{{ route('subject.folder.store', ['subject_id' => $subject->id]) }}"
                          method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if(!is_null($current_folder))
                            <input type="hidden" name="parent_id" value="{{ $current_folder->id }}">
                        @endif
                        @include('components.input', ['attributeName' => 'name', 'required' => 'required'])
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        @if(!is_null($current_folder))
            @if($current_folder->files->count() > 0)
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title">
                                    Files for <strong>{{ $current_folder->name }}</strong> folder
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

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
                                        <td>{{ $file->original_filename}}</td>
                                        <td>
                                            <a href="{{ route('users.detail', ['id' => $file->user->id]) }}">{{ $file->user->user_name }}</a>
                                        </td>
                                        <td>{{ $file->created_at->diffForHumans() }}</td>
                                        <td>{{ $file->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('file.download', ['subject_id' => $subject->id, 'folder' => $current_folder->name, 'file_id' => $file->id]) }}"
                                               class="btn btn-sm btn-default" alt="download" title="download file"><i
                                                        class="fa fa-download"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger disabled" alt="delete"
                                               title="delete file"><i
                                                        class="fa fa-remove"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            @endif
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
                        <form action="{{ route('file.upload', ['subject_id' => $subject->id, 'folder' => $current_folder->name]) }}"
                              method="post"
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