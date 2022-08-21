<?php

namespace App\Services;

use App\Repositories\Eloquent\AddressRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AddressService
{
  /**
   * @var $addressRepository
   */
  protected $addressRepository;



  public function __construct(AddressRepository $addressRepository)
  {
      $this->addressRepository = $addressRepository;
  }

  public function saveAddressData($data)
  {
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

    if ($validator->fails()) {
      throw new InvalidArgumentException($validator->errors()->first());
    }

    $result = $this->addressRepository->save($data);

    return $result;
    
  }
}
