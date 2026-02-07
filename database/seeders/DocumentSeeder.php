<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing documents
        DB::table('documents')->truncate();

        $documents = [
            [
                'filename' => 'Surat Masuk 001',
                'type' => 'surat',
                'jenis' => 'masuk',
                'file_url' => 'documents/surat_masuk_001.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'filename' => 'Surat Keluar 001',
                'type' => 'surat',
                'jenis' => 'keluar',
                'file_url' => 'documents/surat_keluar_001.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'filename' => 'Invoice Pembelian Server',
                'type' => 'invoice',
                'jenis' => 'masuk',
                'file_url' => 'documents/inv_server.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'filename' => 'Invoice Penjualan Jasa',
                'type' => 'invoice',
                'jenis' => 'keluar',
                'file_url' => 'documents/inv_jasa.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'filename' => 'Perjanjian Kredit A',
                'type' => 'kredit',
                'jenis' => null,
                'file_url' => 'documents/kredit_a.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('documents')->insert($documents);
    }
}
