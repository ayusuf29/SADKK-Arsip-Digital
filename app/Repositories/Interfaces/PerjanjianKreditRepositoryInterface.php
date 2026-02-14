<?php

namespace App\Repositories\Interfaces;

interface PerjanjianKreditRepositoryInterface
{
    public function all();
    public function getFiltered($filters);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
