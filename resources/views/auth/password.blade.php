@extends('layouts.default')
@section('content')
    <div class="page-title">
        <span class="title">Password settings</span>
        <div class="description">Change password you log in to Feibox with.</div>
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
                    <form action="{{ route('account.password.update') }}" method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include('components.input', ['password' => 'type="password"' ,'attributeName' => 'current_password', 'required' => 'required'])
                        @include('components.input', ['password' => 'type="password"' ,'attributeName' => 'new_password', 'required' => 'required'])
                        @include('components.input', ['password' => 'type="password"' ,'attributeName' => 'new_password_confirmation', 'required' => 'required', 'helpBlock' => 're-type your new password'])
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop