<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PerjanjianKreditRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PerjanjianKreditController extends Controller
{
    protected $perjanjianKreditRepository;

    public function __construct(PerjanjianKreditRepositoryInterface $perjanjianKreditRepository)
    {
        $this->perjanjianKreditRepository = $perjanjianKreditRepository;
    }

    public function index(Request $request)
    {
        $documents = $this->getFilteredDocuments($request);
        return view('admin.perjanjian-kredit.index', compact('documents'));
    }

    public function export(Request $request)
    {
        if (!$request->filled('period') && (!$request->filled('start_date') || !$request->filled('end_date'))) {
             return redirect()->back()->with('error', 'Please select a period to export.');
        }

        $documents = $this->getFilteredDocuments($request);
        
        $pdf = Pdf::loadView('admin.perjanjian-kredit.pdf', compact('documents'));
        return $pdf->download('perjanjian-kredit-export.pdf');
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
            return $this->perjanjianKreditRepository->getFiltered($filters);
        }

        return $this->perjanjianKreditRepository->all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'nama_peminjam' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $path = $request->file('file')->store('documents/kredit', 'public');

        $this->perjanjianKreditRepository->create([
            'filename' => $request->filename,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'nama_peminjam' => $request->nama_peminjam,
            'file_url' => '/sadkk/public' . Storage::url($path),
        ]);

        return redirect()->route('admin.perjanjian-kredit.index')->with('success', 'Perjanjian Kredit uploaded successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'nama_peminjam' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data = [
            'filename' => $request->filename,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'nama_peminjam' => $request->nama_peminjam,
        ];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents/kredit', 'public');
            $data['file_url'] = '/sadkk/public' . Storage::url($path);
        }

        $this->perjanjianKreditRepository->update($id, $data);

        return redirect()->route('admin.perjanjian-kredit.index')->with('success', 'Perjanjian Kredit updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->perjanjianKreditRepository->delete($id);
        return redirect()->route('admin.perjanjian-kredit.index')->with('success', 'Perjanjian Kredit deleted successfully.');
    }
}
