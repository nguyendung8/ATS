<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $queries = $request->query();
        $users = $this->userRepository->queryAllByConditions($queries)->paginate();

        return UserResource::collection($users);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string',
        ]);
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return response()->json([
            'message' => 'User registered successfully',
        ], 201);
    }
}
