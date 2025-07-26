<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggans')->insert([
            [
                'email' => 'pelanggan1@example.com',
                'password' => Hash::make('password123'),
                'nomor_kwh' => '1234567890',
                'nama_pelanggan' => 'Budi Santoso',
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Merdeka No.1, Jakarta',
                'id_tarif' => 1,
                'status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'pelanggan2@example.com',
                'password' => Hash::make('password123'),
                'nomor_kwh' => '0987654321',
                'nama_pelanggan' => 'Siti Aminah',
                'no_telp' => '082123456789',
                'alamat' => 'Jl. Sudirman No.5, Bandung',
                'id_tarif' => 2,
                'status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'amat@example.com',
                'password' => Hash::make('password123'),
                'nomor_kwh' => '0987654739',
                'nama_pelanggan' => 'Amat Tongtong',
                'no_telp' => '081298765432',
                'alamat' => 'Jl. Sudirman No.7, Depok',
                'id_tarif' => 2,
                'status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'rina@example.com',
                'password' => Hash::make('password123'),
                'nomor_kwh' => '1234509876',
                'nama_pelanggan' => 'Rina Marlina',
                'no_telp' => '085267834561',
                'alamat' => 'Jl. Gatot Subroto No.20, Surabaya',
                'id_tarif' => 1,
                'status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'eko@example.com',
                'password' => Hash::make('password123'),
                'nomor_kwh' => '1029384756',
                'nama_pelanggan' => 'Eko Prasetyo',
                'no_telp' => '087812345678',
                'alamat' => 'Jl. Ahmad Yani No.10, Yogyakarta',
                'id_tarif' => 3,
                'status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
