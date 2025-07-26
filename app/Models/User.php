<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model User untuk mengelola data pengguna/admin sistem
 *
 * Model ini mengextend Laravel Authenticatable untuk fitur autentikasi
 * dan menggunakan traits untuk factory, notifikasi, dan API tokens
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Primary key yang digunakan untuk model ini
     *
     * @var string
     */
    protected $primaryKey = 'id'; // Menggunakan 'id' sesuai dengan migrasi database

    /**
     * Menentukan apakah primary key menggunakan auto increment
     *
     * @var bool
     */
    public $incrementing = true;       // Tetap auto increment

    /**
     * Tipe data dari primary key
     *
     * @var string
     */
    protected $keyType = 'int';        // Bertipe integer

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * Daftar kolom yang diizinkan untuk diisi langsung melalui create() atau fill()
     *
     * @var array<string>
     */
    protected $fillable = [
        'email',
        'password',
        'nama_admin',
        'id_level',
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
     * Relasi Many-to-One dengan model Level
     *
     * Setiap user memiliki satu level/peran tertentu dalam sistem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }
}
