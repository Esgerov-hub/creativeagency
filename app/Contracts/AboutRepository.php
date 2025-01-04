<?php

namespace App\Contracts;

interface AboutRepository
{
    public function create(array $data);
    public function edit($id);
    public function update($id, array $data);
}
