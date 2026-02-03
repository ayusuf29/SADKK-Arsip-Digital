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
        Schema::create('perjanjian_kredits', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pk');
            $table->string('nama_debitur');
            $table->decimal('plafon', 15, 2);
            $table->date('tanggal_akad');
            $table->integer('jangka_waktu')->comment('Dalam bulan');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjanjian_kredits');
    }
};
