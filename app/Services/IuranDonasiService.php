<?php

namespace App\Services;

use App\Models\IuranDonasi;
use App\Models\User;
use Carbon\Carbon;


class IuranDonasiService
{
    /**
     * Buat iuran/donasi baru
     */
    public function create(array $data): IuranDonasi
    {
        return IuranDonasi::create($data);
    }

    /**
     * Ambil semua iuran/donasi
     */
    public function getAll()
    {
        return IuranDonasi::with('user')->get();
    }

    /**
     * Update iuran/donasi berdasarkan ID
     */
    public function update(int $id, array $data): ?IuranDonasi
    {
   $iuran = IuranDonasi::find($id);
    if (!$iuran) return null;

    $iuran->update($data);

    // Jika status diubah menjadi "paid"
    if (isset($data['status']) && $data['status'] === 'paid') {
        $user = $iuran->user; // pastikan relasi iuran->user() ada
        if ($user) {
            $user->last_pay = Carbon::now();
            $user->save();
        }
    }

    return $iuran;
    }

    /**
     * Hapus iuran/donasi berdasarkan ID
     */
    public function delete(int $id): bool
    {
        $iuran = IuranDonasi::find($id);
        if (!$iuran) return false;

        return $iuran->delete();
    }

    public function getById( int $id, ?int $year = null)
    {
    $query = IuranDonasi::where('id', $id);

    // Filter berdasarkan tahun jika diberikan
    if ($year) {
        $query->whereYear('created_at', $year);
    }

    $iuranDonasi = $query->get();

    // Tambahkan field periode (tahun) ke setiap item
    $iuranDonasi->transform(function ($item) {
        $item->periode = $item->created_at->format('Y'); // ambil tahun
        return $item;
    });

    // Hitung total jumlah
    $totalAmount = $iuranDonasi->sum('jumlah');

    return [
        'data' => $iuranDonasi,
        'total_amount' => $totalAmount
    ];
    }

    public function getByUserId( int $id, ?int $year = null)
    {
    $query = IuranDonasi::where('user_id', $id);

    // Filter berdasarkan tahun jika diberikan
    if ($year) {
        $query->whereYear('created_at', $year);
    }

    $iuranDonasi = $query->get();

    // Tambahkan field periode (tahun) ke setiap item
    $iuranDonasi->transform(function ($item) {
        $item->periode = $item->created_at->format('Y'); // ambil tahun
        return $item;
    });

    // Hitung total jumlah
    $totalAmount = $iuranDonasi->sum('jumlah');

    return [
        'data' => $iuranDonasi,
        'total_amount' => $totalAmount
    ];
    }

}
