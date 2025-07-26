<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Pembayaran untuk mengelola data pembayaran tagihan listrik
 *
 * Model ini menyimpan informasi tentang pembayaran yang dilakukan pelanggan
 * termasuk metode pembayaran, bukti pembayaran, dan detail transaksi
 */
class Pembayaran extends Model
{
    use HasFactory;

    /**
     * Primary key yang digunakan untuk model ini
     *
     * @var string
     */
    protected $primaryKey = 'id_pembayaran';

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'id_tagihan',              // Foreign key ke tabel tagihan
        'id_pelanggan',            // Foreign key ke tabel pelanggan
        'tanggal_pembayaran',      // Tanggal kapan pembayaran dilakukan
        'bulan_bayar',             // Bulan yang dibayar
        'metode_pembayaran_id',    // Foreign key ke tabel metode pembayaran
        'biaya_admin',             // Biaya administrasi pembayaran
        'total_bayar',             // Total nominal yang dibayar
        'id',                      // ID admin yang memproses (using 'id' instead of 'id_admin')
        'bukti_pembayaran',        // Path file bukti pembayaran
    ];

    /**
     * Atribut yang akan di-cast ke Carbon instance
     *
     * @var array<string>
     */
    protected $dates = ['tanggal_pembayaran'];

    /**
     * Relasi Many-to-One dengan model Tagihan
     *
     * Setiap pembayaran terkait dengan satu tagihan tertentu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }

    /**
     * Relasi Many-to-One dengan model Pelanggan
     *
     * Setiap pembayaran dilakukan oleh satu pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Relasi Many-to-One dengan model User (Admin)
     *
     * Setiap pembayaran diproses oleh satu admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'id'); // Using 'id' field as you mentioned
    }

    /**
     * Relasi Many-to-One dengan model MetodePembayaran
     *
     * Setiap pembayaran menggunakan satu metode pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id');
    }

    /**
     * Accessor untuk format total pembayaran dalam rupiah
     *
     * @return string
     */
    public function getTotalBayarFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }

    /**
     * Accessor untuk format biaya admin dalam rupiah
     *
     * @return string
     */
    public function getBiayaAdminFormattedAttribute()
    {
        return 'Rp ' . number_format($this->biaya_admin, 0, ',', '.');
    }

    /**
     * Accessor untuk format tanggal pembayaran dalam bahasa Indonesia
     *
     * @return string
     */
    public function getTanggalPembayaranFormattedAttribute()
    {
        return $this->tanggal_pembayaran?->format('d F Y');
    }

    /**
     * Accessor untuk URL bukti pembayaran
     *
     * @return string|null
     */
    public function getBuktiPembayaranUrlAttribute()
    {
        if ($this->bukti_pembayaran) {
            return asset('storage/' . $this->bukti_pembayaran);
        }
        return null;
    }

    /**
     * Scope untuk pembayaran dalam rentang tanggal
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_pembayaran', [$startDate, $endDate]);
    }

    /**
     * Scope untuk pembayaran bulan tertentu
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $bulan
     * @param int $tahun
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByBulan($query, $bulan, $tahun = null)
    {
        $query = $query->where('bulan_bayar', $bulan);

        if ($tahun) {
            $query = $query->whereYear('tanggal_pembayaran', $tahun);
        }

        return $query;
    }

    /**
     * Scope untuk pembayaran berdasarkan metode pembayaran
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $metodeId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMetodePembayaran($query, $metodeId)
    {
        return $query->where('metode_pembayaran_id', $metodeId);
    }
}
