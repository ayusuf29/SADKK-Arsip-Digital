<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\SuratRepositoryInterface;
use App\Models\Surat;

class SuratRepository implements SuratRepositoryInterface
{
    public function all()
    {
        return Surat::all();
    }

    public function find($id)
    {
        return Surat::findOrFail($id);
    }

    public function create(array $data)
    {
        return Surat::create($data);
    }

    public function update($id, array $data)
    {
        $surat = Surat::findOrFail($id);
        $surat->update($data);
        return $surat;
    }

    public function delete($id)
    {
        return Surat::destroy($id);
    }
}
