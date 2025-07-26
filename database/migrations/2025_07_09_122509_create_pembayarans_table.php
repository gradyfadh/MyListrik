<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_tagihan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->date('tanggal_pembayaran');
            $table->integer('bulan_bayar');
            $table->decimal('biaya_admin', 10, 2);
            $table->decimal('total_bayar', 12, 2);
            $table->unsignedBigInteger('id')->nullable();
            $table->timestamps();
            $table->string('bukti_pembayaran');
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihans');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans');
            $table->foreign('id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
