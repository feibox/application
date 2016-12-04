<?php

namespace App;

use App\Exceptions\SystemAccountDoesNotExistsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\User
 *
 * @property integer                                                   $id
 * @property integer                                                   $ais_id
 * @property boolean                                                   $rank
 * @property boolean                                                   $study_level
 * @property string                                                    $email
 * @property string                                                    $user_name
 * @property string                                                    $first_name
 * @property string                                                    $middle_name
 * @property string                                                    $last_name
 * @property string                                                    $title_prefix
 * @property string                                                    $title_suffix
 * @property string                                                    $study_information
 * @property string                                                    $password
 * @property string                                                    $remember_token
 * @property string                                                    $registration_token
 * @property boolean                                                   $is_verified
 * @property boolean                                                   $is_admin
 * @property boolean                                                   $is_valid
 * @property boolean                                                   $is_banned
 * @property boolean                                                   $is_terminated
 * @property \Carbon\Carbon                                            $created_at
 * @property \Carbon\Carbon                                            $updated_at
 * @property-read mixed                                                $full_name
 * @property-read mixed                                                $titled_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAisId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStudyLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereMiddleName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTitlePrefix($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTitleSuffix($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStudyInformation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRegistrationToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsVerified($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsValid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsBanned($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsTerminated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User filesPreview($number = 5)
 * @method static \Illuminate\Database\Query\Builder|\App\User sortable($defaultSortParameters = null)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{

    use Sortable;

    public $sortable = [
        'id',
        'ais_id',
        'email',
        'rank',
        'study_level',
        'user_name',
        'first_name',
        'last_name',
        'is_verified',
        'is_valid',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'registration_token',
    ];

    protected $casts = [
        'is_verified'   => 'bool',
        'is_valid'      => 'bool',
        'is_admin'      => 'bool',
        'is_banned'     => 'bool',
        'is_terminated' => 'bool',
    ];


    /**
     * Boot the model.
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->registration_token = str_random(60);
        });
    }


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }


    public function getFullNameAttribute()
    {
        if (empty($this->first_name) || empty($this->last_name)) {
            return null;
        }

        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }


    public function getTitledNameAttribute()
    {
        return $this->title_prefix.' '.$this->full_name.' '.$this->title_suffix;
    }


    public function verify($token)
    {
        return $this->where('registration_token', $token)->firstOrFail()->confirmEmail();
    }


    public function confirmEmail()
    {
        $this->is_verified = true;
        $this->registration_token = null;
        $this->save();

        return $this;
    }


    public function colleagues()
    {
        return $this->fileCountByUser()->where('users.id', '<>', $this->id)->where('users.study_information', '=',
            $this->study_information)->where('users.rank', '=', $this->rank);
    }


    public function fileCountByUser()
    {
        return $this->with([
            'files' => function ($query) {
                return $query->selectRaw('uploaded_by, count(*) as file_count')->groupBy('uploaded_by');
            }
        ]);
    }


    public function fileCountSortable($query, $direction)
    {
        return $query->leftJoin('files', 'users.id', '=',
            'files.uploaded_by')->selectRaw('users.id, users.ais_id, users.email, users.first_name, users.last_name, users.updated_at, users.user_name, files.uploaded_by, count(files.uploaded_by) as files_count')->groupBy([
            'files.uploaded_by',
            'users.id',
            'users.email',
            'users.first_name',
            'users.last_name',
            'users.updated_at',
            'users.user_name',
            'users.ais_id'
        ])->orderBy('files_count', $direction);
    }


    public function files()
    {
        return $this->hasMany(File::class, 'uploaded_by', 'id');
    }


    /**
     * @param $value
     *
     * @return $this
     */
    public function setIsBanned($value)
    {
        $this->is_banned = $value;
        $this->save();

        return $this;
    }


    /**
     * @param $email
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function findByEmail($email)
    {
        return $this->where('email', $email)->firstOrFail();
    }


    public function systemAccount()
    {
        try {
            return $this->select([ 'id' ])->where('email', 'system@feibox')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new SystemAccountDoesNotExistsException();
        }
    }

    //TODO: Extract this somewhere
    /**
     * @param $display
     *
     * @return string
     */
    public function link($display)
    {
        $url = route('users.detail', [ 'id' => $this->id ]);

        return '<a href='.$url.' class="alert-link">'.$display.'</a>';
    }


    public function exists($term)
    {
        $search_by = $this->determineSearchBy($term);
        try {
            $this->where($search_by, $term)->firstOrFail();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }


    /**
     * @param $term
     *
     * @return string
     */
    private function determineSearchBy($term)
    {
        if (is_numeric($term)) {
            $search_by = 'id';

            return $search_by;
        } elseif (is_email($term)) {
            $search_by = 'email';

            return $search_by;
        } else {
            $search_by = 'user_name';

            return $search_by;
        }
    }


    public function scopeFilesPreview($query, $number = 5)
    {
        return $query->with([
            'files' => function ($query) use ($number) {
                $query->orderBy('updated_at')->limit($number);
            }
        ]);
    }
}
