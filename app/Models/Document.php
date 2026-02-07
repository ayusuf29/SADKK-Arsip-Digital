<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'type',
        'jenis',
        'file_url',
        'nomor_dokumen',
        'tanggal_dokumen',
        'pengirim',
        'penerima',
        'perihal',
        'nama_peminjam',
    ];
}
