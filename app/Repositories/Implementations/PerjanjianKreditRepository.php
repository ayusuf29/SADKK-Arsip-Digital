<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\PerjanjianKreditRepositoryInterface;
use App\Models\PerjanjianKredit;

class PerjanjianKreditRepository implements PerjanjianKreditRepositoryInterface
{
    public function all()
    {
        return PerjanjianKredit::all();
    }

    public function find($id)
    {
        return PerjanjianKredit::findOrFail($id);
    }

    public function create(array $data)
    {
        return PerjanjianKredit::create($data);
    }

    public function update($id, array $data)
    {
        $pk = PerjanjianKredit::findOrFail($id);
        $pk->update($data);
        return $pk;
    }

    public function delete($id)
    {
        return PerjanjianKredit::destroy($id);
    }
}
