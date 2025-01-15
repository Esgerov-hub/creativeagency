<?php

namespace App\Contracts;

interface CharterRepository
{
    public function create(array $data);
    public function edit($id);
    public function update($id, array $data);
}
