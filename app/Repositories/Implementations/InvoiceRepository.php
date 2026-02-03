<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function all()
    {
        return Invoice::all();
    }

    public function find($id)
    {
        return Invoice::findOrFail($id);
    }

    public function create(array $data)
    {
        return Invoice::create($data);
    }

    public function update($id, array $data)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($data);
        return $invoice;
    }

    public function delete($id)
    {
        return Invoice::destroy($id);
    }
}
