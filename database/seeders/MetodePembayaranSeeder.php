<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $data = [
            /* ========= BANK TRANSFER ========= */
            [
                'nama'            => 'Bank Central Asia (BCA)',
                'kode'            => 'BCA',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '1234567890',
                'biaya_admin'     => 2500,
                'deskripsi'       => 'Transfer ke rekening BCA perusahaan.',
                'logo'            => 'images/bca.png',
                'jenis_pembayaran' => 'Bank',
            ],
            [
                'nama'            => 'Bank Mandiri',
                'kode'            => 'MANDIRI',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '1400000001',
                'biaya_admin'     => 2500,
                'deskripsi'       => 'Pembayaran via Mandiri Bill Payment atau transfer biasa.',
                'logo'            => 'images/mandiri.png',
                'jenis_pembayaran' => 'Bank',
            ],
            [
                'nama'            => 'Bank Negara Indonesia (BNI)',
                'kode'            => 'BNI',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '0090000002',
                'biaya_admin'     => 2500,
                'deskripsi'       => 'Pembayaran melalui Virtual Account BNI.',
                'logo'            => 'images/bni.png',
                'jenis_pembayaran' => 'Bank',
            ],
            [
                'nama'            => 'Bank Rakyat Indonesia (BRI)',
                'kode'            => 'BRI',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '002901234567890',
                'biaya_admin'     => 2500,
                'deskripsi'       => 'Support BRImo, ATM & internet banking.',
                'logo'            => 'images/bri.png',
                'jenis_pembayaran' => 'Bank',
            ],
            [
                'nama'            => 'Bank Syariah Indonesia (BSI)',
                'kode'            => 'BSI',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '7131200001',
                'biaya_admin'     => 3000,
                'deskripsi'       => 'Virtual Account & transfer Syariah.',
                'logo'            => 'images/bsi.png',
                'jenis_pembayaran' => 'Bank',
            ],

            /* ========= E‑WALLET / QR ========= */
            [
                'nama'            => 'OVO',
                'kode'            => 'OVO',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '081234567890',
                'biaya_admin'     => 1500,
                'deskripsi'       => 'Pembayaran instan melalui aplikasi OVO.',
                'logo'            => 'images/ovo.png',
                'jenis_pembayaran' => 'E-Wallet',
            ],
            [
                'nama'            => 'GoPay',
                'kode'            => 'GOPAY',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '081234567891',
                'biaya_admin'     => 1500,
                'deskripsi'       => 'Bayar pakai saldo GoPay / GoPayLater.',
                'logo'            => 'images/gopay.png',
                'jenis_pembayaran' => 'E-Wallet',
            ],
            [
                'nama'            => 'DANA',
                'kode'            => 'DANA',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '081234567892',
                'biaya_admin'     => 1500,
                'deskripsi'       => 'Pembayaran cepat lewat aplikasi DANA.',
                'logo'            => 'images/dana.png',
                'jenis_pembayaran' => 'E-Wallet',
            ],
            [
                'nama'            => 'ShopeePay',
                'kode'            => 'SHOPEEPAY',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => '081234567893',
                'biaya_admin'     => 1500,
                'deskripsi'       => 'Gunakan saldo ShopeePay / SPayLater.',
                'logo'            => 'images/spay.png',
                'jenis_pembayaran' => 'E-Wallet',
            ],
            [
                'nama'            => 'QRIS',
                'kode'            => 'QRIS',
                'atas_nama'       => 'PT Voltix Persero',
                'nomor_rekening'  => null,
                'biaya_admin'     => 2000,
                'deskripsi'       => 'Scan kode QRIS untuk semua aplikasi bank/e‑wallet.',
                'logo'            => 'images/qris.png',
                'jenis_pembayaran' => 'QRIS',
            ],
        ];

        /** tambahkan timestamp */
        $data = array_map(fn($d) => $d + ['created_at' => $now, 'updated_at' => $now], $data);

        DB::table('metode_pembayaran')->insert($data);
    }
}
