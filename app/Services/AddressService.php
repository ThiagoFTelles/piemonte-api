<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Repositories\Contracts\AddressRepositoryInterface;

class AddressService
{
  /**
   * @var $addressRepository
   */
  protected $addressRepository;

  /**
   * Validate request data.
   *
   * @param array $data
   * @return \Illuminate\Validation\Validator
   */
  private function dataValidator(array $data) {
    $validator = Validator::make($data, [
      "postal_code" => "required|digits:8",
      "street" => "required|min:3",
      "number" => "max:10",
      "complement" => "min:3",
      "district" => "required|min:3",
      "city" => "required|min:3",
      "state" => "required|size:2",
      "country" => "required|min:3",
    ]);
    return $validator;
  }



  public function __construct(AddressRepositoryInterface $addressRepository)
  {
      $this->addressRepository = $addressRepository;
  }

  public function saveAddressData(array $data)
  {
    $validator = $this->dataValidator($data);

    if ($validator->fails()) {
      throw new InvalidArgumentException($validator->errors()->first());
    }

    $result = $this->addressRepository->save($data);

    return $result;
    
  }

  /**
   * Get all address.
   *
   * @return String
   */
  public function getAll()
  {
      return $this->addressRepository->getAll();
  }

  /**
   * Get address by id.
   *
   * @param number $id
   * @return String
   */
  public function getById($id)
  {
      return $this->addressRepository->getById($id);
  }

  /**
   * Update address data
   * Store to DB if there are no errors.
   *
   * @param array $data
   * @return String
   */
  public function updateAddress($data, $id)
  {
    $validator = $this->dataValidator($data);

      if ($validator->fails()) {
          throw new InvalidArgumentException($validator->errors()->first());
      }

      DB::beginTransaction();

      try {
          $address = $this->addressRepository->update($data, $id);

      } catch (Exception $e) {
          DB::rollBack();
          Log::info($e->getMessage());

          throw new InvalidArgumentException('Unable to update address data');
      }

      DB::commit();

      return $address;

  }

  /**
   * Delete address by id.
   *
   * @param number $id
   * @return String
   */
  public function deleteById($id)
  {
      DB::beginTransaction();

      try {
          $address = $this->addressRepository->delete($id);

      } catch (Exception $e) {
          DB::rollBack();
          Log::info($e->getMessage());

          throw new InvalidArgumentException('Unable to delete address data');
      }

      DB::commit();

      return $address;

  }
}
