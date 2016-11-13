<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\User
 *
 * @property integer $id
 * @property integer $ais_id
 * @property boolean $rank
 * @property boolean $study_level
 * @property string $email
 * @property string $user_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $title_prefix
 * @property string $title_suffix
 * @property string $study_information
 * @property string $password
 * @property string $remember_token
 * @property string $registration_token
 * @property boolean $is_verified
 * @property boolean $is_admin
 * @property boolean $is_valid
 * @property boolean $is_banned
 * @property boolean $is_terminated
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $full_name
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
 * @method static \Illuminate\Database\Query\Builder|\App\User sortable($defaultSortParameters = null)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
        'is_verified' => 'bool',
        'is_valid' => 'bool',
        'is_admin' => 'bool',
        'is_banned' => 'bool',
        'is_terminated' => 'bool'
    ];

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
        'updated_at'
    ];

    /**
     * Boot the model.
     *
     * @return void
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
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function verify($token)
    {
        return $this->where('registration_token', $token)->firstOrFail()->confirmEmail();
    }

    public function setIsBanned($value)
    {
        $this->is_banned = $value;
        $this->save();
        return $this;
    }

    public function confirmEmail()
    {
        $this->is_verified = true;
        $this->registration_token = null;
        $this->save();
        return $this;
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->firstOrFail();
    }
}
