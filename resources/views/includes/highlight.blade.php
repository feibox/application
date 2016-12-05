<div class="modal fade modal-primary" id="modal-{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="label-{{ $file->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="label-{{ $file->id }}">{{ $file->original_filename }} by {{ $file->user->full_name }}</h4>
            </div>
                <div class="modal-body">
                    <pre><code class="hpp">{{ $file->contents() }}</code></pre>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
