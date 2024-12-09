<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActionResource;
use App\Models\Action;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function index()
    {
        return ActionResource::collection(Action::all());
    }
}
