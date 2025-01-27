<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash_id',
        'password',
        'last_seen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }


    public function market(): HasMany
    {
        return $this->hasMany(Market::class);
    }

    
    public function agent(): HasMany
    {
        return $this->hasMany(Agent::class);
    }
    
    
    public function platform(): HasMany
    {
        return $this->hasMany(Platform::class);
    }

    public function support(): HasMany
    {
        return $this->hasMany(Support::class);
    }
    
    public function guest(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
   
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
