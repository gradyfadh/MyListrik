<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Penggunaan untuk mengelola data penggunaan listrik bulanan
 *
 * Model ini menyimpan informasi meter awal dan akhir setiap bulan
 * untuk menghitung konsumsi listrik pelanggan
 */
class Penggunaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     *
     * @var string
     */
    protected $table = 'penggunaans'; // Nama tabel di database

    /**
     * Primary key yang digunakan untuk model ini
     *
     * @var string
     */
    protected $primaryKey = 'id_penggunaan'; // Primary key sesuai skema kamu

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'id_pelanggan',    // Foreign key ke tabel pelanggan
        'bulan',           // Bulan penggunaan (1-12)
        'tahun',           // Tahun penggunaan
        'meter_awal',      // Angka meter di awal bulan
        'meter_akhir',     // Angka meter di akhir bulan
    ];

    /**
     * Relasi Many-to-One dengan model Pelanggan
     *
     * Setiap penggunaan milik satu pelanggan tertentu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Relasi One-to-One dengan model Tagihan
     *
     * Setiap penggunaan akan menghasilkan satu tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'id_penggunaan', 'id_penggunaan');
    }

    /**
     * Accessor untuk menghitung jumlah kWh yang digunakan
     *
     * @return int
     */
    public function getJumlahKwhAttribute()
    {
        return $this->meter_akhir - $this->meter_awal;
    }

    /**
     * Accessor untuk format periode penggunaan
     *
     * @return string
     */
    public function getPeriodeAttribute()
    {
        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return $bulanNama[$this->bulan] . ' ' . $this->tahun;
    }
}
