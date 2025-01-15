<?php

namespace App\Contracts;

interface TranslationRepository
{
    public function create(array $data);
    public function getAll();
}
