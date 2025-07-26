<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Tagihan untuk mengelola data tagihan listrik pelanggan
 *
 * Model ini menyimpan informasi tagihan bulanan berdasarkan penggunaan listrik
 * dan mengelola status pembayaran serta relasi dengan pembayaran
 */
class Tagihan extends Model
{
    use HasFactory;

    /**
     * Primary key yang digunakan untuk model ini
     *
     * @var string
     */
    protected $primaryKey = 'id_tagihan';

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'id_penggunaan',   // Foreign key ke tabel penggunaan
        'id_pelanggan',    // Foreign key ke tabel pelanggan
        'bulan',           // Bulan tagihan (1-12)
        'tahun',           // Tahun tagihan
        'jumlah_meter',    // Total kWh yang digunakan
        'status',          // Status tagihan (belum_bayar, sudah_bayar)
    ];

    /**
     * Relasi Many-to-One dengan model Pelanggan
     *
     * Setiap tagihan milik satu pelanggan tertentu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    /**
     * Relasi Many-to-One dengan model Penggunaan
     *
     * Setiap tagihan berdasarkan satu data penggunaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class, 'id_penggunaan', 'id_penggunaan');
    }

    /**
     * Relasi One-to-Many dengan model Pembayaran
     *
     * Satu tagihan dapat memiliki beberapa catatan pembayaran (histori)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_tagihan', 'id_tagihan');
    }

    /**
     * Relasi One-to-One dengan model Pembayaran terbaru
     *
     * Mendapatkan pembayaran terakhir dari tagihan ini
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pembayaranTerbaru()
    {
        return $this->hasOne(Pembayaran::class, 'id_tagihan', 'id_tagihan')->latest('tanggal_pembayaran');
    }

    /**
     * Accessor untuk generate nomor invoice unik
     *
     * Membuat nomor invoice berdasarkan hash dari ID tagihan
     * untuk keperluan pembayaran dan dokumentasi
     *
     * @return string
     */
    public function getNoInvoiceAttribute(): string
    {
        $hash   = md5($this->attributes['id_tagihan']);
        $digits = preg_replace('/\D/', '', $hash);
        $kode   = substr(str_pad($digits, 10, '0'), 0, 10);
        return '#' . $kode;
    }

    /**
     * Accessor untuk menghitung total tagihan
     *
     * @return float
     */
    public function getTotalTagihanAttribute()
    {
        if ($this->pelanggan && $this->pelanggan->tarif) {
            return $this->jumlah_meter * $this->pelanggan->tarif->tarifperkwh;
        }
        return 0;
    }

    /**
     * Accessor untuk format total tagihan dalam rupiah
     *
     * @return string
     */
    public function getTotalTagihanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_tagihan, 0, ',', '.');
    }

    /**
     * Accessor untuk status tagihan dalam bahasa Indonesia
     *
     * @return string
     */
    public function getStatusFormattedAttribute()
    {
        return $this->status === 'sudah_bayar' ? 'Sudah Bayar' : 'Belum Bayar';
    }
}
