<?php

namespace App\Repositories;



use App\Models\Venues\VenuesModel;
use App\Repositories\Interfaces\VenueRepositoryInterface;

class VenueRepository implements VenueRepositoryInterface
{
  public function create(array $data)
  {
    return VenuesModel::create($data);
  }

  public function findById($id)
  {
    return VenuesModel::find($id);
  }

  public function all()
  {
    return VenuesModel::all();
  }
}