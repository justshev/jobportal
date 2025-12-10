<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cv_path',
        'province',
        'city',
        'district',
        'latitude',
        'longitude',
        'company_document',
        'verification_status',
        'rejection_reason',
        'verified_at',
        'verified_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Check if user is verified (HR users need admin approval)
     * 
     * @return bool
     */
    public function isVerified(): bool
    {
        if ($this->role !== 'hr') {
            return true; // Non-HR users don't need verification
        }
        return $this->verification_status === 'approved';
    }

    /**
     * Check if user needs verification
     * 
     * @return bool
     */
    public function needsVerification(): bool
    {
        return $this->role === 'hr' && $this->verification_status === 'pending';
    }

    // Relationships
    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'posted_by');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
