<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Subject
 *
 * @property integer                                                                 $id
 * @property integer                                                                 $ais_id
 * @property string                                                                  $code
 * @property boolean                                                                 $study_level
 * @property boolean                                                                 $study_year
 * @property boolean                                                                 $is_valid
 * @property boolean                                                                 $is_enabled
 * @property \Carbon\Carbon                                                          $created_at
 * @property \Carbon\Carbon                                                          $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubjectTranslation[] $translations
 * @property-read mixed                                                              $name_en
 * @property-read mixed                                                              $name_sk
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Folder[]             $folders
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereAisId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereStudyLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereStudyYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereIsValid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereIsEnabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject sortable($defaultSortParameters = null)
 * @mixin \Eloquent
 */
class Subject extends Model
{

    use Sortable;

    public $sortable = [
        'id',
        'code',
        'study_level',
        'study_year',
        'is_valid',
        'is_enabled',
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'ais_id',
        'code',
        'study_level',
        'study_year',
        'is_valid',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'bool',
        'is_valid'   => 'bool',
    ];


    public static function create(array $attributes = [])
    {
        $model = parent::create(array_except($attributes, [ 'sk', 'en' ]));

        if (array_has($attributes, [ 'sk', 'en' ])) {
            if ( ! empty($attributes['sk'] && ! empty($attributes['en']))) {
                $model->translations()->saveMany([
                    new \App\SubjectTranslation(array_merge($attributes['sk'], [ 'language' => 'sk' ])),
                    new \App\SubjectTranslation(array_merge($attributes['en'], [ 'language' => 'en' ])),
                ]);

                if (is_null($model->study_year)) {
                    $model->update([ 'is_valid' => true ]);
                } else {
                    $model->update([ 'is_valid' => true, 'is_enabled' => true ]);
                }
            }
        }

        return $model;
    }


    public function update(array $attributes = [], array $options = [])
    {
        return parent::update(array_except($attributes, [ 'sk', 'en' ]), $options);
    }


    public function translations()
    {
        return $this->hasMany(SubjectTranslation::class)->select([ 'id', 'subject_id', 'name', 'language' ]);
    }


    public function getNameEnAttribute()
    {
        return $this->translations->where('language', '=', 'en')->first()->name;
    }


    public function getNameSkAttribute()
    {
        return $this->translations->where('language', '=', 'sk')->first()->name;
    }


    public function codeSortable($query, $direction)
    {
        return $query->select(DB::raw('*, (CASE WHEN code REGEXP \'^(B-|I-)\' = 1 THEN TRIM(SUBSTR(code, 3)) ELSE code END) as code_trimmed'))->orderBy('code_trimmed',
            $direction);
    }


    public function nameEnSortable($query, $direction)
    {
        return $this->formNameSortingQuery($query, $direction);
    }


    private function formNameSortingQuery($query, $direction, $language = 'en')
    {
        return $query->join('subject_translations', function ($join) use ($language) {
            $join->on('subjects.id', '=', 'subject_translations.subject_id')->where('subject_translations.language',
                '=', $language);
        })->orderBy('subject_translations.name', $direction)->select('subjects.*');
    }


    public function nameSkSortable($query, $direction)
    {
        return $this->formNameSortingQuery($query, $direction, 'sk');
    }


    public function rootFolders()
    {
        return $this->folders()->where('parent_id', null);
    }


    public function folders()
    {
        return $this->hasMany(Folder::class);
    }
}
