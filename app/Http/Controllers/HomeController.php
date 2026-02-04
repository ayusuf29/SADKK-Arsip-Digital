<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Document;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $suratMasuk = Document::where('type', 'surat')->where('jenis', 'masuk')->count();
        $suratKeluar = Document::where('type', 'surat')->where('jenis', 'keluar')->count();
        $invoiceMasuk = Document::where('type', 'invoice')->where('jenis', 'masuk')->count();
        $invoiceKeluar = Document::where('type', 'invoice')->where('jenis', 'keluar')->count();
        $kredit = Document::where('type', 'kredit')->count();

        return view('home', compact('suratMasuk', 'suratKeluar', 'invoiceMasuk', 'invoiceKeluar', 'kredit'));
    }
}
