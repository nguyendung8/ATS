<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResumeTemplateResource;
use App\Models\ResumeTemplate;

class ResumeTemplateController extends Controller
{
    public function index()
    {
        return ResumeTemplateResource::collection(ResumeTemplate::all());
    }
}
