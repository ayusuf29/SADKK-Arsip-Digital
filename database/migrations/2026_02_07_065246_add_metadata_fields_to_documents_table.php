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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('nomor_dokumen')->nullable()->after('jenis'); // Stores no_surat, no_invoice, no_pk
            $table->date('tanggal_dokumen')->nullable()->after('nomor_dokumen'); // Stores tanggal_surat, tanggal_invoice, tanggal_pk
            $table->string('pengirim')->nullable()->after('tanggal_dokumen'); // Stores dari (Surat Masuk, Invoice Masuk)
            $table->string('penerima')->nullable()->after('pengirim'); // Stores tujuan_surat, tujuan_invoice
            $table->string('perihal')->nullable()->after('penerima'); // Stores perihal (Surat)
            $table->string('nama_peminjam')->nullable()->after('perihal'); // Stores nama_peminjam (Perjanjian Kredit)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_dokumen',
                'tanggal_dokumen',
                'pengirim',
                'penerima',
                'perihal',
                'nama_peminjam'
            ]);
        });
    }
};
