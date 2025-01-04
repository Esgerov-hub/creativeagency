<?php
namespace App\Repositories;
use App\Contracts\AboutRepository;
use App\Models\About;

class AboutRepositoryImpl implements AboutRepository
{
    protected $model;

    public function __construct()
    {
        $this->model  = new About();
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
