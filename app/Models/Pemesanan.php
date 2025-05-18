<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pemesanan';

    protected $keyType = 'string';

    protected $table = 'pemesanan';

    protected $fillable = [
        'id_pemesanan',
        'id_user',
        'alamat',
        'metode_pembayaran',
        'total_harga',
        'status',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_pemesanan', 'id_pemesanan');
    }


    // Relasi ke item pemesanan
    public function item_pemesanan()
    {
        return $this->hasMany(ItemPemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    // app/Models/Pemesanan.php

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            1 => $this->metode_pembayaran == 'COD' ? 'Menunggu Konfirmasi' : 'Menunggu Pembayaran', // Menunggu Konfirmasi untuk COD
            2 => 'Diproses',
            3 => 'Dikirim',
            4 => 'Selesai',
            5 => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            0 => 'warning',
            1 => 'info',
            2 => 'primary',
            3 => 'dark',
            4 => 'success',
            5 => 'danger',
            default => 'secondary',
        };
    }
}
