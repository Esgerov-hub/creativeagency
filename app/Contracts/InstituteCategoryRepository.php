<?php

namespace App\Contracts;

interface InstituteCategoryRepository
{
    public function getAll();
    public function create(array $data);
    public function edit($id);
    public function update($id, array $data);
    public function delete($id);
}
