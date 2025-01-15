<?php

namespace App\Repositories;

use App\Contracts\ServiceRepository;
use App\Models\Service;

class ServiceRepositoryImpl implements ServiceRepository
{
    protected $model;
    protected $service;

    public function __construct()
    {
        $this->model  = new Service();
        $this->service = Service::ordered()->get();
    }

    public function getAll()
    {
        return $this->service;
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
