<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Subject
 *
 * @property integer $id
 * @property integer $ais_id
 * @property string $code
 * @property boolean $study_level
 * @property boolean $study_year
 * @property boolean $valid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubjectTranslation[] $translations
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereAisId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereStudyLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereStudyYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereValid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subject extends Model
{
    protected $fillable = [
        'ais_id',
        'code',
        'study_level',
        'study_year',
        'valid',
    ];

    public static function create(array $attributes = [])
    {
        $model = parent::create(array_except($attributes, ['sk', 'en']));

        if (array_has($attributes, ['sk', 'en'])) {
            if (!empty($attributes['sk'] && !empty($attributes['en']))) {
                $model->translations()->saveMany([
                    new \App\SubjectTranslation(array_merge($attributes['sk'], ['language' => 'sk'])),
                    new \App\SubjectTranslation(array_merge($attributes['en'], ['language' => 'en'])),
                ]);
                $model->update(['valid' => true]);
            }
        }

        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        return parent::update(array_except($attributes, ['sk', 'en']), $options);
    }

    public function translations()
    {
        return $this->hasMany(SubjectTranslation::class);
    }
}
