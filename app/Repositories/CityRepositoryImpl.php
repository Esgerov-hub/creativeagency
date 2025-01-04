<?php
namespace App\Repositories;

use App\Contracts\CityRepository;
use App\Models\City;

class CityRepositoryImpl implements CityRepository
{
    protected $model;
    protected $city;

    public function __construct()
    {
        $this->model  = new City();
        $this->city = City::orderBy('id','DESC')->get();
    }

    public function getAll()
    {
        return $this->city;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
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
