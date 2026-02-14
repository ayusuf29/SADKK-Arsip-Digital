<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SuratRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    protected $suratRepository;

    public function __construct(SuratRepositoryInterface $suratRepository)
    {
        $this->suratRepository = $suratRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $documents = $this->getFilteredDocuments($request);
        return view('admin.surat.index', compact('documents'));
    }

    public function export(Request $request)
    {
        if (!$request->filled('period') && (!$request->filled('start_date') || !$request->filled('end_date'))) {
             return redirect()->back()->with('error', 'Please select a period to export.');
        }

        $documents = $this->getFilteredDocuments($request);
        
        $pdf = Pdf::loadView('admin.surat.pdf', compact('documents'));
        return $pdf->download('surat-export.pdf');
    }

    private function getFilteredDocuments(Request $request)
    {
        $filters = [];
        $startDate = null;
        $endDate = null;

        if ($request->filled('period') && $request->period !== 'custom') {
            $endDate = Carbon::now();
            switch ($request->period) {
                case '1_month':
                    $startDate = Carbon::now()->subMonth();
                    break;
                case '3_months':
                    $startDate = Carbon::now()->subMonths(3);
                    break;
                case '6_months':
                    $startDate = Carbon::now()->subMonths(6);
                    break;
                case '1_year':
                    $startDate = Carbon::now()->subYear();
                    break;
            }
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
        }

        if ($startDate && $endDate) {
            $filters['start_date'] = $startDate->format('Y-m-d');
            $filters['end_date'] = $endDate->format('Y-m-d');
            return $this->suratRepository->getFiltered($filters);
        }

        return $this->suratRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'nomor_dokumen' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB
        ]);

        $path = $request->file('file')->store('documents/surat', 'public');

        $this->suratRepository->create([
            'filename' => $request->filename,
            'jenis' => $request->jenis,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'pengirim' => $request->pengirim,
            'penerima' => $request->penerima,
            'perihal' => $request->perihal,
            'file_url' => '/sadkk/public' . Storage::url($path),
        ]);

        return redirect()->route('admin.surat.index')->with('success', 'Surat uploaded successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'nomor_dokumen' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data = [
            'filename' => $request->filename,
            'jenis' => $request->jenis,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'pengirim' => $request->pengirim,
            'penerima' => $request->penerima,
            'perihal' => $request->perihal,
        ];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents/surat', 'public');
            $data['file_url'] = '/sadkk/public' . Storage::url($path);
        }

        $this->suratRepository->update($id, $data);

        return redirect()->route('admin.surat.index')->with('success', 'Surat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->suratRepository->delete($id);
        return redirect()->route('admin.surat.index')->with('success', 'Surat deleted successfully.');
    }
}
