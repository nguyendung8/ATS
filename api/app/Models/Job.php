<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Job extends Model
{
//    use HasFactory, SoftDeletes, Searchable; // SD Elastic Search
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'country',
        'city',
        'employment_type',
        'description',
        'requirement',
        'benefit',
        'min_offer',
        'max_offer',
        'currency',
        'deadline',
        'photo_url',
        'status',
        'pipeline_id',
        'user_id',
    ];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_jobs');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'job_tags');
    }

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function candidateJobs()
    {
        return $this->hasMany(CandidateJob::class);
    }

    public function interviews()
    {
        return $this->hasManyThrough(Interview::class, CandidateJob::class);
    }

    // Creator of the job
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
