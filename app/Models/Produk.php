<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = "produk";
    protected $primaryKey = 'id_produk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_produk', 'id_menu', 'nama', 'deskripsi', 'harga', 'foto', 'status'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }


    public function item_keranjang()
    {
        return $this->hasMany(ItemKeranjang::class, 'id_produk', 'id_produk');
    }
}
