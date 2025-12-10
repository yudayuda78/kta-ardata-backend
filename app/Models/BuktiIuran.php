<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuktiIuran extends Model
{
       use HasFactory;
        protected $table = 'buktiiuran';

    protected $fillable = [
        'iuran_id',
        'image',
        'keterangan',
    ];

    public function iuran()
    {
        return $this->belongsTo(IuranDonasi::class, 'iuran_id');
    }
}
