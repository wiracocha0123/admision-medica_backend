<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Traits\ApiResponse;

class UsersController extends Controller
{
    use ApiResponse;

    /**
     * Return paginated users (protected by role middleware).
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 25);
        $users = User::with('roles')
            ->select('id','name','email','created_at')
            ->orderBy('name')
            ->paginate($perPage);

        return $this->success($users);
    }
}
