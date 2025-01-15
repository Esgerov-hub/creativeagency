<?php
namespace App\Repositories;
use App\Contracts\ComplaintRepository;
use App\Models\Complaint;

class ComplaintRepositoryImpl implements ComplaintRepository
{
    protected $model;

    public function __construct()
    {
        $this->model  = new Complaint();
    }

    public function first()
    {
        return $this->model->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->whereId($id)->update($data);
    }
}
