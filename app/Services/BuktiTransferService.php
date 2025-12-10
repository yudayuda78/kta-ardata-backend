<?php

namespace App\Services;

use App\Models\BuktiIuran;

class BuktiTransferService
{
    /**
     * Buat bukti transfer baru
     */
    public function create(array $data): BuktiIuran
    {
        return BuktiIuran::create($data);
    }
}
