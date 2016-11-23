<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'filename',
        'original_filename',
        'mime',
        'folder_id',
        'uploaded_by'
    ];

    public function folder() {
        return $this->belongsTo(Folder::class);
    }
}
