<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reason',
        'mail_template_id',
    ];

    public function candidateJobs()
    {
        return $this->hasMany(CandidateJob::class);
    }

    public function mailTemplate()
    {
        return $this->belongsTo(MailTemplate::class);
    }
}
