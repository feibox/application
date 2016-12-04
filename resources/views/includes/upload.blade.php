<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="title">
                    File Upload drop-zone will come here
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('files.upload') }}"
                  method="post"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="folder_id" value="{{ $current_folder->id }}">
                <input type="file" name="uploading_file">
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>