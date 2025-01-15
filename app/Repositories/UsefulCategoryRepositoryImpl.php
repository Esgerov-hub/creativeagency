<?php

namespace App\Repositories;

use App\Contracts\UsefulCategoryRepository;
use App\Models\UsefulCategory;

class UsefulCategoryRepositoryImpl implements UsefulCategoryRepository
{
    protected $model;
    protected $category;

    public function __construct()
    {
        $this->model  = new UsefulCategory();
        $this->category = UsefulCategory::with('parentCategories')->orderBy('id','DESC')->get();
    }

    public function getAll()
    {
        return $this->category;
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
