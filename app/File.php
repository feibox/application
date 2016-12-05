<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\File
 *
 * @property integer          $id
 * @property string           $filename
 * @property string           $mime
 * @property integer          $size
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
 * @method static \Illuminate\Database\Query\Builder|\App\File whereSize($value)
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
        'size',
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


    /**
     * @return bool
     */
    public function previewable()
    {
        return ($this->size < 10000) && (in_array($this->mime, [
                'cpp',
                'hpp',
                'c',
                'h',
                'json',
                'php',
                'xml',
                'html',
                'bash',
                'sh',
                'conf',
                'txt',
                'js',
                'bat',
                'm',
                'css',
                'less',
                'sass',
                'log',
                'go',
                'py',
                'swift',
                'make'
            ]));
    }


    public function contents()
    {
        $storage = resolve(\Illuminate\Filesystem\FilesystemManager::class);
        if ($storage->exists($this->filename) && $storage->size($this->filename) < 10000) {
            return ltrim($storage->get($this->filename));
        }
    }
}
