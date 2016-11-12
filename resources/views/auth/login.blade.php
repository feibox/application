@extends('layouts.auth')
@section('content')
    <div class="login-box">
        <div>
            <div class="login-form row">
                <div class="col-sm-12 text-center login-header">
                    <i class="login-logo fa fa-first-order fa-5x"></i>
                    <h3 class="login-title">Feibox <span class="text-info">Panel</span></h3>
                    <h6 class="text-primary">Want an account? <a href="{{ route('register', ['email' => old('email')]) }}">Register here!</a></h6>
                </div>
                <div class="col-sm-12">
                    <div class="login-body">
                        @notification()
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{!! $error !!}</p>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}
                            <div class="control">
                                <input type="email" class="form-control" placeholder="e-mail" name="email"
                                       required="required" value="{{ old('email') }}"/>
                            </div>
                            <div class="control">
                                <input type="password" class="form-control" name="password" required="required"/>
                            </div>
                            <div class="login-button text-center">
                                <input type="submit" class="btn btn-primary" value="Login">
                            </div>
                        </form>
                    </div>
                    <div class="login-footer">
                        <div class="text-right">Made with <i class="fa fa-heart text-danger"></i>.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop