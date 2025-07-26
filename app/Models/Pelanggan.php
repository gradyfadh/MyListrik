<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Stringable;
use Illuminate\Support\Str;

/**
 * Model Pelanggan untuk mengelola data pelanggan listrik
 *
 * Model ini mengextend Laravel Authenticatable untuk fitur login pelanggan
 * dan mengelola data pelanggan beserta relasi dengan tarif dan tagihan
 */
class Pelanggan extends Authenticatable
{
    use HasFactory;

    /**
     * Primary key yang digunakan untuk model ini
     *
     * @var string
     */
    protected $primaryKey = 'id_pelanggan';

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'nama_pelanggan',  // Nama lengkap pelanggan
        'email',           // Email untuk login dan komunikasi
        'nomor_kwh',       // Nomor meteran kWh unik
        'alamat',          // Alamat lengkap pelanggan
        'id_tarif',        // Foreign key ke tabel tarif
        'password',        // Password untuk login
        'status',          // Status aktif/nonaktif
        'no_telp',         // Nomor telepon pelanggan
    ];

    /**
     * Atribut yang disembunyikan dari serialization
     *
     * Kolom-kolom sensitif yang tidak akan ditampilkan dalam JSON response
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut ke tipe data tertentu
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi Many-to-One dengan model Tarif
     *
     * Setiap pelanggan memiliki satu jenis tarif listrik
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif');
    }

    /**
     * Relasi One-to-Many dengan model Tagihan
     *
     * Satu pelanggan dapat memiliki banyak tagihan listrik
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_pelanggan');
    }

    /**
     * Accessor untuk format nomor telepon dengan kode negara
     *
     * Mengubah format nomor telepon lokal menjadi format internasional (+62)
     *
     * @return string
     */
    public function getNoTelpFormattedAttribute()
    {
        if (!$this->no_telp) {
            return '-';
        }

        // Hilangkan angka 0 di awal (jika ada), lalu ganti jadi +62
        $telp = ltrim($this->no_telp, '0');

        return '+62 ' . $telp;
    }
}
