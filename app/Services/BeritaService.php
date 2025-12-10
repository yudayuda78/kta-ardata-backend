<?php

namespace App\Services;

use App\Models\Berita;

class BeritaService
{
    /**
     * Ambil semua berita.
     */
    public function getAll()
    {
        return Berita::all();
    }

    /**
     * Ambil satu berita berdasarkan ID.
     */
    public function getById($id)
    {
        return Berita::findOrFail($id);
    }

    /**
     * Simpan berita baru.
     */
    public function create(array $data)
    {
        return Berita::create([
            'judul'   => $data['judul'],
            'penulis' => $data['penulis'],
            'tanggal' => $data['tanggal'],
            'artikel' => $data['artikel'],
        ]);
    }

    /**
     * Update berita.
     */
    public function update($id, array $data)
    {
        $berita = Berita::findOrFail($id);

        $berita->update($data);

        return $berita;
    }

    /**
     * Hapus berita.
     */
    public function delete($id)
    {
        $berita = Berita::findOrFail($id);

        return $berita->delete();
    }
}
