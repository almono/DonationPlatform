<?php

namespace App\Repositories;

use App\Interfaces\DonationRepositoryInterface;
use App\Models\Donation;
use Illuminate\Support\Collection;

class DonationRepository implements DonationRepositoryInterface
{
    public function sendDonation(array $donationData) : ?Donation
    {
        return Donation::create($donationData);
    }
}