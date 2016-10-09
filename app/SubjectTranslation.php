<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectTranslation extends Model
{
    protected $fillable = [
        'name',
        'language'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
