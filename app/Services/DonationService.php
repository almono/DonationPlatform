<?php

namespace App\Services;

use App\Models\Donation;
use App\Repositories\DonationRepository;
use Illuminate\Support\Collection;

class DonationService
{
    public function __construct(
        private DonationRepository $donationRepository
    ) {}

    public function sendDonation(array $donationData) : ?Donation
    {
        return $this->donationRepository->sendDonation($donationData);
    }
}