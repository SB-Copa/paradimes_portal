<?php


namespace App\Actions\Venue;

use App\Repositories\Interfaces\VenueRepositoryInterface;

class CreateVenueAction
{
    protected $venueRepo;

    public function __construct(VenueRepositoryInterface $venueRepo)
    {
        $this->venueRepo = $venueRepo;
    }

    public function execute(array $data)
    {
        return $this->venueRepo->create($data);
    }
}