<?php
namespace App\Repositories;

use App\Contracts\UsefulLinkRepository;
use App\Models\UsefulLink;

class UsefulLinkRepositoryImpl implements UsefulLinkRepository
{
    protected $model;
    protected $useful_link;

    public function __construct()
    {
        $this->model  = new UsefulLink();
        $this->useful_link = UsefulLink::orderBy('id','DESC')->get();
    }

    public function getAll()
    {
        return $this->useful_link;
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
