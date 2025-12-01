<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'tags',
        'company',
        'logo',
        'location',
        'email',
        'phone',
        'address',
        'contact_person',
        'website',
        'description',
        'status'
    ];

    // Default values
    protected $attributes = [
        'status' => 'pending'
    ];

    // Casting untuk memastikan tipe data konsisten
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ✅ TAMBAHKAN ACCESSOR UNTUK LOGO URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo && \Storage::disk('public')->exists($this->logo)) {
            return \Storage::disk('public')->url($this->logo);
        }
        
        // Fallback ke placeholder atau company initial
        return $this->getPlaceholderLogo();
    }

    // ✅ METHOD UNTUK PLACEHOLDER LOGO
    protected function getPlaceholderLogo()
    {
        // Return placeholder image path atau generate initial
        return asset('images/company-placeholder.png');
    }

    // ✅ TAMBAHKAN ACCESSOR UNTUK COMPANY INITIAL (jika mau pakai initial)
    public function getCompanyInitialAttribute()
    {
        return strtoupper(substr($this->company, 0, 1));
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%')
                ->orWhere('company', 'like', '%' . request('search') . '%')
                ->orWhere('location', 'like', '%' . request('search') . '%');
        }
    }

    // Scopes for status filtering
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Scope untuk listing yang aktif (approved)
    public function scopeActive($query)
    {
        return $query->where('status', 'approved');
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to Applications
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // Count applications
    public function applicationCount()
    {
        return $this->applications()->count();
    }

    // Count pending applications
    public function pendingApplicationsCount()
    {
        return $this->applications()->where('status', 'pending')->count();
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Check if user has applied to this listing
    public function userHasApplied($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->applications()->where('user_id', $userId)->exists();
    }

    // Get tags as array
    public function getTagsArrayAttribute()
    {
        return array_map('trim', explode(',', $this->tags));
    }
}