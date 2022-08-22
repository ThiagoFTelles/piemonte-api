<?php

namespace App\Repositories\Eloquent;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
  protected $model;

  public function __construct()
  {
    $this->model = $this->resolveModel();
  }

  public function getAll()
  {
    return $this->model->all();
  }

    /**
   * Get model by id
   *
   * @param number $id
   * @return mixed
   */
  public function getById($id)
  {
      return $this->model
          ->where('id', $id)
          ->get();
  }

    /**
   * Delete Model
   *
   * @param number $data
   * @return Model
   */
  public function delete($id)
  {
      
      $model = $this->model->find($id);
      $model->delete();

      return $model;
  }

  protected function resolveModel()
  {
    return app($this->model);
  }
}
