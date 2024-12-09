<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function pipelineStages()
    {
        return $this->belongsToMany(PipelineStage::class, 'action_pipeline_stages');
    }

    public function actionPipelineStages()
    {
        return $this->hasMany(ActionPipelineStage::class);
    }
}
