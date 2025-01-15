<?php

namespace App\Contracts;

interface ComplaintRepository
{
    public function first();
    public function create(array $data);
    public function update($id, array $data);
}
