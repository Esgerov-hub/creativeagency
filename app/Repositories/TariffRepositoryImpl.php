<?php

namespace App\Repositories;
use App\Contracts\TariffRepository;
use App\Models\Tariff;

class TariffRepositoryImpl implements TariffRepository
{
    protected $model;

    public function __construct()
    {
        $this->model  = new Tariff();
    }

    public function getAll()
    {
        return $this->model->with('parentTariff')->whereNull('parent_id')->orderBy('id','DESC')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function edit($id)
    {
        return $this->model->whereId($id)->first();
    }

    public function update($id, array $data)
    {
        return $this->model->whereId($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->whereId($id)->delete();
    }
}
