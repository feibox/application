<ol class="breadcrumb navbar-breadcrumb">
    @foreach(Request::segments() as $segment)
        @continue($segment === 'admin' or is_numeric($segment))
        @if($loop->last)
            <li class="cursor-default active">{{ ucfirst($segment) }}</li>
        @else
            <li class="cursor-default">{{ ucfirst($segment) }}</li>
        @endif
    @endforeach
</ol>