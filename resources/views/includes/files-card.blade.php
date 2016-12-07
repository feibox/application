<div class="card-body">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>file name</th>
            <th>uploaded by</th>
            <th>created at</th>
            <th>updated at</th>
            <th>options</th>
        </tr>
        </thead>
        <tbody>
        @foreach($files as $file)
            <tr>
                <td>{{ str_limit($file->original_filename, 24)}}</td>
                <td>
                    <a href="{{ route('users.detail', ['id' => $file->uploaded_by]) }}">{{ $file->user->user_name }}</a>
                </td>
                <td>{{ $file->created_at->diffForHumans() }}</td>
                <td>{{ $file->updated_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('files.download', ['file' => $file->id]) }}"
                       class="btn btn-sm btn-default" alt="download" title="download file"><i
                                class="fa fa-download"></i></a>
                    @if($file->previewable())
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-{{ $file->id }}">
                            <i class="fa fa-code"></i>
                        </button>
                        @include('includes.highlight', ['file' => $file])
                    @endif
                    @can('destroy', $file)
                        <a href="{{ route('files.destroy', ['file' => $file->id]) }}" class="btn btn-sm btn-danger" alt="delete"
                           title="delete file"><i class="fa fa-remove"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>