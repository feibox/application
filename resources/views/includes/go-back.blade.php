@unless(url()->previous() == url()->current())
    <a href="{{ url()->previous() }}" class="btn btn-default full-width" role="button"><i class="fa fa-arrow-left"></i> go back</a>
@endunless