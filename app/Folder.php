<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Folder
 *
 * @property integer                                                     $id
 * @property string                                                      $name
 * @property integer                                                     $subject_id
 * @property integer                                                     $parent_id
 * @property integer                                                     $created_by
 * @property \Carbon\Carbon                                              $created_at
 * @property \Carbon\Carbon                                              $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Folder[] $folders
 * @property-read \App\Folder                                            $parentFolder
 * @property-read \App\User                                              $user
 * @property-read \App\Subject                                           $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Folder[] $childFolders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[]   $files
 * @method static \Illuminate\Database\Query\Builder|\App\Folder whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Folder whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Folder whereSubjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Folder whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Folder whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Folder whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Folder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Folder extends Model
{

    protected $fillable = [
        'name',
        'subject_id',
        'parent_id',
        'created_by',
    ];

    protected $casts = [
        'is_root' => 'bool',
    ];

    protected $touches = ['folders', 'subject'];


    public function initialize(Subject $subject)
    {
        $folders = [ 'lectures', 'seminar', 'exams' ];

        foreach ($folders as $folder) {
            $this->create([
                'name'       => $folder,
                'subject_id' => $subject->id,
                'created_by' => system_account()->id,
            ]);
        }
    }


    /**
     * @return bool
     */
    public function isEmpty()
    {
        if ( ! $this->relationLoaded('folders')) {
            $this->load('folders');
        }

        if ( ! $this->relationLoaded('files')) {
            $this->load('files');
        }

        return $this->files->isEmpty() && $this->folders->isEmpty();
    }


    public function folders()
    {
        return $this->hasMany(self::class, 'parent_id');
    }


    public function parentFolder()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }


    public function childFolders()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }


    public function files()
    {
        return $this->hasMany(File::class, 'folder_id', 'id');
    }
}
