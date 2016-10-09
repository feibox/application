@extends('layouts.auth')
@section('content')
    <div class="register-box">
        <div>
            <div class="register-form row">
                <div class="col-sm-12 text-center register-header">
                    <i class="register-logo fa fa-registered fa-5x"></i>
                    <h3 class="register-title">Feibox <span class="text-info">Registration</span></h3>
                </div>
                <div class="col-sm-12">
                    <div class="register-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('register') }}" method="post">
                            {{ csrf_field() }}
                            <div class="control">
                                <input type="email" class="form-control" placeholder="stuba e-mail" name="email"
                                       required="required" value="{{ old('email') }}"/>
                            </div>
                            <div class="control">
                                <input type="password" placeholder="password" class="form-control" name="password" required="required"/>
                            </div>
                            <div class="control">
                                <input type="password" placeholder="password confirmation" class="form-control" name="password_confirmation" required="required"/>
                            </div>
                            <div class="register-button text-center">
                                <input type="submit" class="btn btn-primary" value="Register">
                            </div>
                        </form>
                    </div>
                    <div class="register-footer">
                        <span class="text-right">Made with <i class="fa fa-heart text-danger"></i>.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop