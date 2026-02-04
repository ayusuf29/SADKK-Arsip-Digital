<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PerjanjianKreditRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerjanjianKreditController extends Controller
{
    protected $perjanjianKreditRepository;

    public function __construct(PerjanjianKreditRepositoryInterface $perjanjianKreditRepository)
    {
        $this->perjanjianKreditRepository = $perjanjianKreditRepository;
    }

    public function index()
    {
        $documents = $this->perjanjianKreditRepository->all();
        return view('admin.perjanjian-kredit.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $path = $request->file('file')->store('documents/kredit', 'public');

        $this->perjanjianKreditRepository->create([
            'filename' => $request->filename,
            'file_url' => Storage::url($path),
        ]);

        return redirect()->route('admin.perjanjian-kredit.index')->with('success', 'Perjanjian Kredit uploaded successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data = ['filename' => $request->filename];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents/kredit', 'public');
            $data['file_url'] = Storage::url($path);
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
