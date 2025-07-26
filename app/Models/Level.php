<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Level untuk mengelola data level/peran pengguna
 *
 * Model ini menyimpan informasi tentang tingkatan atau peran pengguna
 * dalam sistem seperti admin, super admin, operator, dll
 */
class Level extends Model
{
    use HasFactory;

    /**
     * Primary key yang digunakan untuk model ini
     *
     * @var string
     */
    protected $primaryKey = 'id_level';

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'nama_level'    // Nama level/peran (contoh: Admin, Super Admin, Operator)
    ];

    /**
     * Relasi One-to-Many dengan model User
     *
     * Satu level dapat dimiliki oleh banyak pengguna
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_level');
    }

    /**
     * Accessor untuk format nama level dengan kapitalisasi
     *
     * @return string
     */
    public function getNamaLevelFormattedAttribute()
    {
        return ucwords(strtolower($this->nama_level));
    }

    /**
     * Scope untuk mencari level berdasarkan nama
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $nama
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByNama($query, $nama)
    {
        return $query->where('nama_level', 'like', '%' . $nama . '%');
    }
}
