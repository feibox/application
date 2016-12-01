<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\File
 *
 * @property integer          $id
 * @property string           $filename
 * @property string           $mime
 * @property string           $original_filename
 * @property integer          $uploaded_by
 * @property integer          $folder_id
 * @property \Carbon\Carbon   $created_at
 * @property \Carbon\Carbon   $updated_at
 * @property-read \App\Folder $folder
 * @property-read \App\User   $user
 * @method static \Illuminate\Database\Query\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File whereOriginalFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File whereUploadedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File whereFolderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class File extends Model
{

    protected $fillable = [
        'filename',
        'original_filename',
        'mime',
        'folder_id',
        'uploaded_by',
    ];

    protected $casts = [
        'id'          => 'integer',
        'uploaded_by' => 'integer',
    ];


    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
