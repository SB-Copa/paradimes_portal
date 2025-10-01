<?php


namespace App\Repositories\Interfaces;

interface VenueRepositoryInterface
{

    public function create(array $data);
    public function findById($id);
    public function all();
}