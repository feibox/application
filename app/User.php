<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
 * @property boolean $verified
 * @property boolean $is_admin
 * @property boolean $is_valid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
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
 * @method static \Illuminate\Database\Query\Builder|\App\User whereVerified($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsValid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

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
        'verified' => 'bool',
        'is_valid' => 'bool',
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

    public function verify($token)
    {
        $this->where('registration_token', $token)->firstOrFail()->confirmEmail();
    }

    public function confirmEmail()
    {
        $this->verified = true;
        $this->registration_token = null;
        $this->save();
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->firstOrFail();
    }
}
