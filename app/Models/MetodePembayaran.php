<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model MetodePembayaran untuk mengelola data metode pembayaran
 *
 * Model ini menyimpan informasi tentang berbagai metode pembayaran
 * yang tersedia untuk pelanggan seperti bank transfer, e-wallet, dll
 */
class MetodePembayaran extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     *
     * @var string
     */
    protected $table = 'metode_pembayaran';

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'nama',                // Nama metode pembayaran (contoh: BCA, Mandiri, GoPay)
        'kode',                // Kode unik metode pembayaran
        'atas_nama',           // Nama pemilik rekening/akun
        'nomor_rekening',      // Nomor rekening atau nomor akun
        'biaya_admin',         // Biaya administrasi tambahan
        'deskripsi',           // Deskripsi detail metode pembayaran
        'logo',                // Path file logo metode pembayaran
        'is_aktif',            // Status aktif/nonaktif metode pembayaran
        'jenis_pembayaran',    // Jenis pembayaran (bank, ewallet, tunai)
    ];

    /**
     * Casting atribut ke tipe data tertentu
     *
     * @var array<string, string>
     */
    protected $casts = [
        'biaya_admin' => 'decimal:2',
        'is_aktif' => 'boolean',
    ];

    /**
     * Scope untuk metode pembayaran aktif
     *
     * Query scope untuk mendapatkan hanya metode pembayaran yang aktif
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * Accessor untuk format biaya admin dalam rupiah
     *
     * @return string
     */
    public function getBiayaAdminFormatAttribute()
    {
        return 'Rp ' . number_format($this->biaya_admin, 0, ',', '.');
    }

    /**
     * Accessor untuk status dalam bahasa Indonesia
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->is_aktif ? 'Aktif' : 'Nonaktif';
    }

    /**
     * Accessor untuk URL logo metode pembayaran
     *
     * Mengembalikan URL logo atau default logo jika tidak ada
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('storage/images/default-payment.png');
    }

    /**
     * Relasi One-to-Many dengan model Pembayaran
     *
     * Satu metode pembayaran dapat digunakan untuk banyak pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'metode_pembayaran_id');
    }

    /**
     * Scope untuk filter berdasarkan jenis pembayaran
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $jenis
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_pembayaran', $jenis);
    }
}
