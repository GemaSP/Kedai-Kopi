<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $keyType = 'string';

    protected $fillable = [
        'id_transaksi',
        'id_pemesanan',
        'status_pembayaran',
        'jumlah_bayar',
    ];

    /**
     * Relasi dengan model Pemesanan
     */
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }
}
