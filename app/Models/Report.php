<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_posting_id',
        'reason',
        'description',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getReasonLabelAttribute()
    {
        $reasons = [
            'spam' => 'Spam',
            'inappropriate' => 'Inappropriate Content',
            'fake' => 'Fake Job Posting',
            'misleading' => 'Misleading Information',
            'other' => 'Other',
        ];

        return $reasons[$this->reason] ?? $this->reason;
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Pending Review',
            'reviewing' => 'Under Review',
            'resolved' => 'Resolved',
            'rejected' => 'Rejected',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'reviewing' => 'blue',
            'resolved' => 'green',
            'rejected' => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }
}

