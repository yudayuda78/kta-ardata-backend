<?php

namespace App\Http\Controllers;

use App\Models\IuranDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\IuranDonasiService;

class IuranDonasiController extends Controller
{
    protected $service;

    public function __construct(IuranDonasiService $service)
    {
        $this->service = $service;
    }

    /**
     * Simpan iuran atau donasi baru
     */
     public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|in:iuran,donasi',
            'jumlah' => 'required|numeric',
            'metode' => 'required|string',
            'status' => 'required|string|in:pending,paid,cancelled',
        ]);

        $userId = Auth::id();

        $iuranDonasi = $this->service->create([
            'user_id' => $userId,
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'jumlah' => $request->jumlah,
            'metode' => $request->metode,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'data' => $iuranDonasi
        ]);
    }

    /**
     * Ambil semua iuran/donasi
     */
    public function index()
    {
        $data = $this->service->getAll();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update iuran/donasi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'tipe' => 'sometimes|string|in:iuran,donasi',
            'jumlah' => 'sometimes|numeric',
            'metode' => 'sometimes|string',
            'status' => 'sometimes|string|in:pending,paid,cancelled',
        ]);

        $updated = $this->service->update($id, $request->all());

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $updated]);
       
    }

    /**
     * Hapus iuran/donasi
     */
    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }

    public function show($id)
    {
         /** @var \App\Models\User|null $user */
    $user = auth()->user();

    $userId = $user?->id;


        $iuranDonasi = $this->service->getById( $userId);

        if (!$iuranDonasi) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        return response()->json([
            'success' => true,  
            'data' => $iuranDonasi
                // 'user' => $iuranDonasi,
        ]);
    }

}
