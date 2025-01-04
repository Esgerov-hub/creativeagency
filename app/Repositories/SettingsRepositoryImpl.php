<?php

namespace App\Repositories;

use App\Contracts\SettingsRepository;
use App\Models\Setting;

class SettingsRepositoryImpl implements SettingsRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Setting();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->whereId($id)->update($data);
    }

}
