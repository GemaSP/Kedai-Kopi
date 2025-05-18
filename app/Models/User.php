<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Keranjang;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'user';
    protected $primaryKey = 'id_user'; // tambahkan ini
    public $incrementing = false; // karena ID-nya bukan integer auto-increment
    protected $keyType = 'string'; // karena ID-nya string (USR001)

    protected $fillable = [
        'id_user',
        'nama',
        'email',
        'password',
        'status',
        'role',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel pelanggan
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    // Relasi ke keranjang
    public function keranjang()
    {
        return $this->hasOne(Keranjang::class, 'id_user', 'id_user');
    }
}
