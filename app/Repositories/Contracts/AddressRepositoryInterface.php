<?php

namespace App\Repositories\Contracts;

interface AddressRepositoryInterface
{
  public function getAll();
  public function getById($id);
  public function delete($id);
  public function save($data);
  public function update($data, $id);
}
