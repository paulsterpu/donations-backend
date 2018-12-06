<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends EloquentUser implements AuthenticatableContract
{
    use Notifiable, HasApiTokens, Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'permissions',
        'telefon',
        'nume',
        'adresa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function donation_offers() {
        $this->hasMany(DonationOffer::class);
    }

    public function donation_requests() {
        $this->hasMany(DonationRequest::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
