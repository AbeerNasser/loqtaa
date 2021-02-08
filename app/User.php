<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password', 'image', 'city', 'address',
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

    public function delegates()
    {
        return $this->hasMany('App\Models\Delegate');
    }

    public function stores()
    {
        return $this->hasMany('App\Models\Store');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    // public function scopeHasRole($query, $role)
    // {
    //     $query->where('role', '=', $role);
    // }

    // public function roles()
    // {
    //     return $this->belongsToMany('App\Models\Role');
    // }
}
