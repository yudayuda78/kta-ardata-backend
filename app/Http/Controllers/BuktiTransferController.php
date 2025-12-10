<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BuktiTransferService;
use Illuminate\Support\Facades\Storage;

class BuktiTransferController extends Controller
{
    protected $service;

    public function __construct(BuktiTransferService $service)
    {
        $this->service = $service;
    }

    /**
     * Simpan bukti transfer baru
     */
public function store(Request $request)
{
    $request->validate([
        'iuran_id' => 'required|integer',
        'image' => 'required|image|max:2048',               
        'keterangan' => 'nullable|string',                      
    ]);


    $imagePath = $request->file('image')->store('bukti_transfers', 'public');

    $bukti = $this->service->create([
        'iuran_id' => $request->iuran_id,
        'image' => $imagePath,
        'keterangan' => $request->keterangan,
    ]);
    

    return response()->json([
        'success' => true,
        'data' => $bukti
        
    ]);

}

}
