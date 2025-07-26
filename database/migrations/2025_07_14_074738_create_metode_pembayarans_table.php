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
        // Drop table if exists first (for schema conflicts)
        Schema::dropIfExists('metode_pembayaran');

        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('atas_nama');
            $table->string('nomor_rekening')->nullable();
            $table->decimal('biaya_admin', 8, 2)->default(0.00);
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->enum('jenis_pembayaran', ['E-Wallet', 'Bank', 'QRIS', 'Retail'])->default('Bank');
            $table->timestamps();
        });

        // Add foreign key to pembayarans table if it exists
        if (Schema::hasTable('pembayarans')) {
            Schema::table('pembayarans', function (Blueprint $table) {
                if (!Schema::hasColumn('pembayarans', 'metode_pembayaran_id')) {
                    $table->unsignedBigInteger('metode_pembayaran_id')->nullable();
                    $table->foreign('metode_pembayaran_id')->references('id')->on('metode_pembayaran')->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key from pembayarans table if it exists
        if (Schema::hasTable('pembayarans')) {
            Schema::table('pembayarans', function (Blueprint $table) {
                $table->dropForeign(['metode_pembayaran_id']);
                $table->dropColumn('metode_pembayaran_id');
            });
        }

        Schema::dropIfExists('metode_pembayaran');
    }
};
