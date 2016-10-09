<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
