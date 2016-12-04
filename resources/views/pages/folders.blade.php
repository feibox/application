@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">
                            Folder
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
                        <table class="table table-hover rowlink" data-link="row">
                            <thead>
                            <tr>
                                <th>folder name</th>
                                <th>created by</th>
                                <th>created at</th>
                                <th>updated at</th>
                                <th>options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($folders as $folder)
                                <tr>
                                    <td>
                                        <a href="{{ route('subjects.folder', ['subject_id' => $subject->id, 'folder' => $folder_prefix . $folder->name]) }}">{{ $folder->name}}</a>
                                    </td>
                                    <td>
                                        {{ $folder->user->user_name }}
                                    </td>
                                    <td>{{ $folder->created_at->diffForHumans() }}</td>
                                    <td>{{ $folder->updated_at->diffForHumans() }}</td>
                                    <td class="rowlink-skip">
                                        @can('destroy', $folder)
                                            <a href="{{ route('folders.destroy', ['folder' => $folder->id]) }}" class="btn btn-sm btn-danger" alt="remove" title="remove"><i class="fa fa-remove"></i></a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-danger disabled" alt="remove" title="remove"><i class="fa fa-remove"></i></a>
                                        @endcan
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
                    <form action="{{ route('subjects.folder.store', ['subject_id' => $subject->id]) }}"
                          method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if(!is_null($current_folder))
                            <input type="hidden" name="parent_id" value="{{ $current_folder->id }}">
                        @endif
                        @include('components.input', ['attributeName' => 'name', 'required' => 'required'])
                        <button type="submit" class="btn btn-primary">Create Folder</button>
                    </form>
                </div>
            </div>
        </div>
        @if(!is_null($current_folder))
            @include('includes.files', ['files' => $current_folder->files])
            @include('includes.upload', ['subject' => $subject, 'current_folder' => $current_folder])
        @endif
        <div class="col-sm-12">
            @include('includes.go-back')
        </div>
    </div>
@stop