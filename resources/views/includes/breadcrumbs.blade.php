<ol class="breadcrumb navbar-breadcrumb">
    @if(request()->segment(1) === 'subjects')
        @foreach(breadcrumb_subject_folders($subject) as $folder)
            @if($loop->last)
                <li class="cursor-default active">{!! $folder !!}</li>
            @else
                <li class="cursor-default">{!! $folder !!}</li>
            @endif
        @endforeach
    @elseif(request()->segment(1) === 'colleagues' && isset($colleague))
        <li class="cursor-default"> <a href="{{ route('colleagues.index') }}">Colleagues</a></li>
        <li class="cursor-default active">{{ ucfirst($colleague->full_name) }}</li>
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