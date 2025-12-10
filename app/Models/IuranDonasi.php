<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IuranDonasi extends Model
{
    use HasFactory;

    protected $table = 'iurandonasi'; // nama tabel
    protected $casts = [
    'jumlah' => 'integer',
];

    protected $fillable = [
        'user_id',
        'nama',
        'tipe',
        'jumlah',
        'metode',
        'status',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
