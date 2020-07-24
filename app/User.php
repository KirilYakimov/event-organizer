<?php

namespace App;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#
# Down the line we might want to remove the
# the commented out implements MustVerifyEmail
# and CanResetPassword. For making this work
# this functionality is not essential
#

class User extends Authenticatable # implements MustVerifyEmail, CanResetPassword
{
    use Notifiable;

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_id', 'username', 'email', 'password', 'firstname', 'lastname', 'image', 'organizer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
