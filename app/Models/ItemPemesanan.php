<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPemesanan extends Model
{
    use HasFactory;

    protected $table = 'item_pemesanan';

    protected $fillable = [
        'id_pemesanan',
        'id_produk',
        'quantity',
        'harga_satuan',
        'total',
    ];

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
