<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship with Listings
    public function listings()
    {
        return $this->hasMany(Listing::class, 'user_id');
    }

    // Relationship with Applications
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isAdmin()
    {
        return $this->is_admin == 1;
    }

    // Check if user has applied to a listing
    public function hasApplied($listingId)
    {
        return $this->applications()->where('listing_id', $listingId)->exists();
    }
}