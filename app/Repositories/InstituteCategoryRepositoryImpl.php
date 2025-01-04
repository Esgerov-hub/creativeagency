<?php
namespace App\Repositories;

use App\Contracts\InstituteCategoryRepository;
use App\Models\Category;
use App\Models\InstituteCategory;

class InstituteCategoryRepositoryImpl implements InstituteCategoryRepository
{
    protected $model;
    protected $instituteCategory;

    public function __construct()
    {
        $this->model  = new InstituteCategory();
        $this->instituteCategory = InstituteCategory::orderBy('id','DESC')->get();
    }

    public function getAll()
    {
        return $this->instituteCategory;
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
