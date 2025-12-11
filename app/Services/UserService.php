<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Ambil semua user
     */
    public function getAll()
    {
        return User::all();
    }

    /**
     * Ambil user berdasarkan ID
     */
    public function getById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update data user
     */
    public function update(int $id, array $data): ?User
    {
        $user = User::find($id);
        if (!$user) return null;

        $user->update($data);
        return $user;
    }

    /**
     * Hapus user
     */
    public function delete(int $id): bool
    {
        $user = User::find($id);
        if (!$user) return false;

        return $user->delete();
    }
}
