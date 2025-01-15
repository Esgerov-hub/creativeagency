<?php

namespace App\Contracts;

interface SettingsRepository
{
    public function store(array $data);
    public function update($id, array $data);
}
