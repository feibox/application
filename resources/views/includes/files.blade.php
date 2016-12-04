@if($files->count() > 0)
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                        Files
                    </div>
                </div>
            </div>
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
                            <td>{{ $file->original_filename}}</td>
                            <td>
                                <a href="{{ route('users.detail', ['id' => $file->user->id]) }}">{{ $file->user->user_name }}</a>
                            </td>
                            <td>{{ $file->created_at->diffForHumans() }}</td>
                            <td>{{ $file->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('files.download', ['file' => $file->id]) }}"
                                   class="btn btn-sm btn-default" alt="download" title="download file"><i
                                            class="fa fa-download"></i></a>
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
        </div>
    </div>
@endif