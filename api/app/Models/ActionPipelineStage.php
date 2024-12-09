<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionPipelineStage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'action_id',
        'pipeline_stage_id',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
