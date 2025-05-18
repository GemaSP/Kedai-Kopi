<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_user'; // tambahkan ini
    public $incrementing = false; // karena ID-nya bukan integer auto-increment
    protected $keyType = 'string'; // karena ID-nya string (KRJ001001)

    protected $fillable = ['id_keranjang', 'id_user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item_keranjang()
    {
        return $this->hasMany(ItemKeranjang::class, 'id_keranjang', 'id_keranjang');
    }
}
