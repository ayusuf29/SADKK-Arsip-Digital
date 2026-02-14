<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Models\Document;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function all()
    {
        return Document::where('type', 'invoice')->orderBy('created_at', 'desc')->get();
    }

    public function getFiltered($filters)
    {
        $query = Document::where('type', 'invoice');

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('tanggal_dokumen', [$filters['start_date'], $filters['end_date']]);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function find($id)
    {
        return Document::where('type', 'invoice')->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['type'] = 'invoice';
        return Document::create($data);
    }

    public function update($id, array $data)
    {
        $invoice = Document::where('type', 'invoice')->findOrFail($id);
        $invoice->update($data);
        return $invoice;
    }

    public function delete($id)
    {
        $invoice = Document::where('type', 'invoice')->findOrFail($id);
        return $invoice->delete();
    }
}
