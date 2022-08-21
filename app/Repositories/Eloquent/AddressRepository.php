<?php

namespace App\Repositories\Eloquent;

use App\Models\Address;
use App\Repositories\Contracts\AddressRepositoryInterface;

class AddressRepository extends AbstractRepository implements AddressRepositoryInterface
{
  /**
   * @var Address
   */
  protected $model;

  /**
   * PostRepository constructor.
   *
   * @param Address $post
   */
  public function __construct(Address $model)
  {
      $this->model = $model;
  }

    /**
   * Save Address
   *
   * @param $data
   * @return Address
   */
  public function save($data)
  {
      $model = new $this->model;

      $model->postal_code = $data['postal_code'];
      $model->street = $data['street'];
      $model->number = $data['number'];
      $model->complement = $data['complement'];
      $model->district = $data['district'];
      $model->city = $data['city'];
      $model->state = $data['state'];
      $model->country = $data['country'];

      $model->save();

      return $model->fresh();
  }
}
