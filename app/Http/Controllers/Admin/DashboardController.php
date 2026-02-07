<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Cache;

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

        // Cache yesterday's total (count at start of today)
        $yesterday = Cache::remember('metric_' . $type . '_' . ($jenis ?? 'all') . '_' . date('Y-m-d'), 60 * 24, function () use ($type, $jenis) {
            $q = Document::where('type', $type);
            if ($jenis) {
                $q->where('jenis', $jenis);
            }
            return $q->where('created_at', '<', now()->startOfDay())->count();
        });

        $diff = $current - $yesterday;
        $pct = $yesterday > 0 ? ($diff / $yesterday) * 100 : ($diff > 0 ? 100 : 0);

        return [
            'total' => $current,
            'diff' => $diff,
            'pct' => number_format($pct, 1)
        ];
    }
}
