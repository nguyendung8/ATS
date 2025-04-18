<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected PermissionRepositoryInterface $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Permission::class);
        $queries = $request->query();
        $permissions = $this->permissionRepository->queryAllByConditions($queries)->get();

        return PermissionResource::collection($permissions);
    }

    public function show(Permission $permission)
    {
        $this->authorize('view', Permission::class);

        return PermissionResource::make($permission);
    }
}
