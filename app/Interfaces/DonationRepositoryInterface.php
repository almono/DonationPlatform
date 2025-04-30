<?php

namespace App\Interfaces;

use App\Models\Donation;
use Illuminate\Support\Collection;

interface DonationRepositoryInterface
{
    public function sendDonation(array $donationData) : ?Donation;
}
