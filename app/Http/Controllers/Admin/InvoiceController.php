<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    protected $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index()
    {
        $documents = $this->invoiceRepository->all();
        return view('admin.invoice.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $path = $request->file('file')->store('documents/invoice', 'public');

        $this->invoiceRepository->create([
            'filename' => $request->filename,
            'jenis' => $request->jenis,
            'file_url' => Storage::url($path),
        ]);

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice uploaded successfully.');
    }

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
            $path = $request->file('file')->store('documents/invoice', 'public');
            $data['file_url'] = Storage::url($path);
        }

        $this->invoiceRepository->update($id, $data);

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->invoiceRepository->delete($id);
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
