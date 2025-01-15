<?php
namespace App\Repositories;
use App\Contracts\CharterRepository;
use App\Models\About;
use App\Models\Charter;

class CharterRepositoryImpl implements CharterRepository
{
    protected $model;

    public function __construct()
    {
        $this->model  = new Charter();
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
}
