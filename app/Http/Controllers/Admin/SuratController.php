<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SuratRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function index()
    {
        $documents = $this->suratRepository->all();
        return view('admin.surat.index', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB
        ]);

        $path = $request->file('file')->store('documents/surat', 'public');

        $this->suratRepository->create([
            'filename' => $request->filename,
            'jenis' => $request->jenis,
            'file_url' => Storage::url($path),
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
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data = [
            'filename' => $request->filename,
            'jenis' => $request->jenis,
        ];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents/surat', 'public');
            $data['file_url'] = Storage::url($path);
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
