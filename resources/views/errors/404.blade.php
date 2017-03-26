@extends('layouts.error')
@section('content')
    <div class="container">
        <div class="content_err">
            <div class="title_err"><strong>#404</strong><br>Page not found!</div>
            <br>
            @unless(url()->previous() == url()->current())
                <a class="link_err" href="{{ url()->previous() }}">Please, take me back :(</a>
            @endunless
        </div>
    </div>
@stop

