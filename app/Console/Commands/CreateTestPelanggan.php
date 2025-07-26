<?php

namespace App\Console\Commands;

use App\Models\Pelanggan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestPelanggan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:test-pelanggan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test pelanggan account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => 'Test Pelanggan',
            'email' => 'pelanggan@test.com',
            'nomor_kwh' => 'TEST001',
            'alamat' => 'Jl. Test No. 1',
            'id_tarif' => 1, // Assuming tarif ID 1 exists
            'password' => Hash::make('password'),
            'status' => 'aktif',
            'no_telp' => '081234567890',
        ]);

        $this->info('Test pelanggan created successfully!');
        $this->info('Email: pelanggan@test.com');
        $this->info('Password: password');

        return 0;
    }
}
