<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SubjectTranslation
 *
 * @property integer           $id
 * @property integer           $subject_id
 * @property string            $language
 * @property string            $name
 * @property \Carbon\Carbon    $created_at
 * @property \Carbon\Carbon    $updated_at
 * @property-read \App\Subject $subject
 * @method static \Illuminate\Database\Query\Builder|\App\SubjectTranslation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SubjectTranslation whereSubjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SubjectTranslation whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SubjectTranslation whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SubjectTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SubjectTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubjectTranslation extends Model
{

    protected $fillable = [
        'name',
        'language',
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
