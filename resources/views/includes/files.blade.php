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
            @include('includes.files-card', ['files' => $files])
        </div>
    </div>
@endif
