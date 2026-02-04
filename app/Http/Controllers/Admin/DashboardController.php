<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        $suratMasuk = Document::where('type', 'surat')->where('jenis', 'masuk')->count();
        $suratKeluar = Document::where('type', 'surat')->where('jenis', 'keluar')->count();
        $invoiceMasuk = Document::where('type', 'invoice')->where('jenis', 'masuk')->count();
        $invoiceKeluar = Document::where('type', 'invoice')->where('jenis', 'keluar')->count();
        $kredit = Document::where('type', 'kredit')->count();

        return view('admin.dashboard', compact('suratMasuk', 'suratKeluar', 'invoiceMasuk', 'invoiceKeluar', 'kredit'));
    }
}
