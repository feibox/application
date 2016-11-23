<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
        'name',
        'subject_id',
        'parent_id',
        'created_by'
    ];

    protected $casts = [
        'is_root' => 'bool'
    ];

    public function folders()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'parent_id', 'id');
    }

    public function childFolders()
    {
        return $this->hasMany(Folder::class, 'parent_id', 'id');
    }

    public function scopeSubject($query, $subject_id)
    {
        return $query->where('subject_id', '=', $subject_id);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

}
