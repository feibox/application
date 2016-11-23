@extends('layouts.default')
@section('content')
    <div class="page-title">
        <span class="title">Create folder</span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap!</strong> Change a few things up and try submitting again.
                        </div>
                    @endif
                    <form action="{{ route('subject.folder.store', ['subject_id' => $subject->id]) }}" method="post"
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
    </div>
@stop