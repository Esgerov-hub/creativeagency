<?php

namespace App\Contracts;

interface CmsUserRepository
{
    public function getAll();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
