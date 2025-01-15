<?php
namespace App\Repositories;
use App\Contracts\UsefulRepository;
use App\Models\Category;
use App\Models\Useful;

class UsefulRepositoryImpl implements UsefulRepository
{
    protected $model;

    public function __construct()
    {
        $this->model  = new Useful();
    }

    public function getAll()
    {
        return $this->model->with(['category','parentCategory','subParentCategory'])->orderBy('id','DESC')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function edit($id)
    {
        return $this->model->with(['category','parentCategory','subParentCategory'])->whereId($id)->first();
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
