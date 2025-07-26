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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_kwh')->unique();
            $table->string('nama_pelanggan');
            $table->string('no_telp')->nullable();
            $table->text('alamat');
            $table->unsignedBigInteger('id_tarif');
            $table->enum('status', ['waiting', 'aktif'])->default('waiting');
            $table->timestamps();

            $table->foreign('id_tarif')->references('id_tarif')->on('tarifs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
