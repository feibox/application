<ol class="breadcrumb navbar-breadcrumb">
    @if(request()->segment(1) === 'subjects')
        @foreach(breadcrumb_subject_folders($subject) as $folder)
            @if($loop->last)
                <li class="cursor-default active">{!! $folder !!}</li>
            @else
                <li class="cursor-default">{!! $folder !!}</li>
            @endif
        @endforeach
    @else
        @foreach(request()->segments() as $segment)
            @continue($segment === 'admin' or is_numeric($segment))
            @if($loop->last)
                <li class="cursor-default active">{{ ucfirst($segment) }}</li>
            @else
                <li class="cursor-default">{{ ucfirst($segment) }}</li>
            @endif
        @endforeach
    @endif
</ol>