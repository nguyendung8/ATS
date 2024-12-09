<?php

namespace App\Http\Controllers;

use App\Http\Resources\RejectionResource;
use App\Models\Rejection;

class RejectionController extends Controller
{
    public function index()
    {
        return RejectionResource::collection(Rejection::all());
    }
}
