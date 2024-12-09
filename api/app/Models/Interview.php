<?php

namespace App\Models;

use App\Enums\Interview\InterviewStaffType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Interview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'note',
        'is_online',
        'link',
        'status',
        'score',
        'candidate_job_id',
        'mail_template_id',
        'mail_title',
        'mail_content',
        'room_id',
        'staff_id',
        'assessment_form_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hash_id',
    ];

    protected function hashId(): Attribute
    {
        return new Attribute(
            get: fn () => Hashids::encode($this->id),
        );
    }

    public function candidateJob()
    {
        return $this->belongsTo(CandidateJob::class);
    }

    public function mailTemplate()
    {
        return $this->belongsTo(MailTemplate::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function interviewStaffs()
    {
        return $this->hasMany(InterviewStaff::class);
    }

    public function interviewers()
    {
        return $this->belongsToMany(Staff::class, 'interview_staffs');
    }

    public function scheduler()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function assessmentForm()
    {
        return $this->belongsTo(AssessmentForm::class);
    }
}
