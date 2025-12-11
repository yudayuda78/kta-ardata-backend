<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get semua user
     */
    public function index()
    {
        $users = $this->userService->getAll();
        return response()->json($users);
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'nomortelepon', 'alamat', 'role', 'last_pay', 'point', 'password']);
        
        // jika ada password baru, hash dulu
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = $this->userService->update($id, $data);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $deleted = $this->userService->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function show($id)
{
    try {
        $user = $this->userService->getById($id);
        return response()->json($user);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'User not found'], 404);
    }
}
}
