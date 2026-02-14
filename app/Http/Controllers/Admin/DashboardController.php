<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'suratMasuk' => $this->getMetric('surat', 'masuk'),
            'suratKeluar' => $this->getMetric('surat', 'keluar'),
            'invoiceMasuk' => $this->getMetric('invoice', 'masuk'),
            'invoiceKeluar' => $this->getMetric('invoice', 'keluar'),
            'kredit' => $this->getMetric('kredit'),
        ];

        return view('admin.dashboard', $metrics);
    }

    private function getMetric($type, $jenis = null)
    {
        $query = Document::where('type', $type);
        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $current = $query->count();

        return [
            'total' => $current
        ];
    }
}
