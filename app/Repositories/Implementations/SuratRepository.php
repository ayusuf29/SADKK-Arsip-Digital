<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\SuratRepositoryInterface;
use App\Models\Document;

class SuratRepository implements SuratRepositoryInterface
{
    public function all()
    {
        return Document::where('type', 'surat')->orderBy('created_at', 'desc')->get();
    }

    public function find($id)
    {
        return Document::where('type', 'surat')->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['type'] = 'surat';
        return Document::create($data);
    }

    public function update($id, array $data)
    {
        $surat = Document::where('type', 'surat')->findOrFail($id);
        $surat->update($data);
        return $surat;
    }

    public function delete($id)
    {
        $surat = Document::where('type', 'surat')->findOrFail($id);
        return $surat->delete();
    }
}
