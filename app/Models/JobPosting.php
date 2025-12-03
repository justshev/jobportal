<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company_name',
        'location',
        'employment_type',
        'salary_range',
        'description',
        'requirements',
        'posted_by',
        'status',
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'job_id');
    }
}
