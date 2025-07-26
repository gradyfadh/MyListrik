<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Tarif untuk mengelola data tarif listrik
 *
 * Model ini menyimpan informasi tentang jenis tarif listrik
 * berdasarkan daya dan harga per kWh yang berlaku
 */
class Tarif extends Model
{
    use HasFactory;

    /**
     * Primary key yang digunakan untuk model ini
     *
     * @var string
     */
    protected $primaryKey = 'id_tarif';

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'kode_tarif',      // Kode unik tarif (contoh: R1, R2, B1, dll)
        'daya',            // Daya listrik dalam VA (contoh: 450, 900, 1300)
        'tarifperkwh',     // Harga per kWh dalam rupiah
        'deskripsi',       // Deskripsi detail tarif
    ];

    /**
     * Relasi One-to-Many dengan model Pelanggan
     *
     * Satu tarif dapat digunakan oleh banyak pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'id_tarif', 'id_tarif');
    }

    /**
     * Accessor untuk format harga tarif per kWh
     *
     * @return string
     */
    public function getTarifFormattedAttribute()
    {
        return 'Rp ' . number_format($this->tarifperkwh, 0, ',', '.');
    }

    /**
     * Accessor untuk format daya dengan satuan
     *
     * @return string
     */
    public function getDayaFormattedAttribute()
    {
        return $this->daya . ' VA';
    }
}
