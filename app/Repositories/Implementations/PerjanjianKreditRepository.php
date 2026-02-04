<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\PerjanjianKreditRepositoryInterface;
use App\Models\Document;

class PerjanjianKreditRepository implements PerjanjianKreditRepositoryInterface
{
    public function all()
    {
        return Document::where('type', 'kredit')->orderBy('created_at', 'desc')->get();
    }

    public function find($id)
    {
        return Document::where('type', 'kredit')->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['type'] = 'kredit';
        return Document::create($data);
    }

    public function update($id, array $data)
    {
        $kredit = Document::where('type', 'kredit')->findOrFail($id);
        $kredit->update($data);
        return $kredit;
    }

    public function delete($id)
    {
        $kredit = Document::where('type', 'kredit')->findOrFail($id);
        return $kredit->delete();
    }
}
