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
   * AddressRepository constructor.
   *
   * @param Address $model
   */
  public function __construct(Address $model)
  {
      $this->model = $model;
  }

    /**
   * Save Address
   *
   * @param array $data
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

  /**
   * Update Address
   *
   * @param array $data
   * @return Address
   */
  public function update($data, $id)
  {
      
      $address = $this->model->find($id);

      $address->postal_code = $data['postal_code'];
      $address->street = $data['street'];
      $address->number = $data['number'];
      $address->complement = $data['complement'];
      $address->district = $data['district'];
      $address->city = $data['city'];
      $address->state = $data['state'];
      $address->country = $data['country'];

      $address->update();

      return $address;
  }

}
