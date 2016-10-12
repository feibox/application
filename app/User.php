<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function confirmEmail()
    {
        $this->verified = true;
        $this->registration_token = null;
        $this->save();
    }
}
