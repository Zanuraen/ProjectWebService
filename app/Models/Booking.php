<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'bookings';

    /**
     * Kolom-kolom yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'user_id',
        'name',
        'class_name',
        'date',
        'time',
        'notes',
        'status',
        'reservation_code', // Kode unik untuk kasir
    ];

    /**
     * Relasi: Booking ini dimiliki oleh satu User (Member).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Format atribut agar lebih mudah dibaca (opsional).
     */
    protected $casts = [
        'date' => 'date',
    ];
}