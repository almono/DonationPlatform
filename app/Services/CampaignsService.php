<?php

namespace App\Services;

use App\Models\Campaign;
use App\Repositories\CampaignsRepository;
use Illuminate\Support\Collection;

class CampaignsService
{
    public function __construct(
        private CampaignsRepository $campaignsRepository
    ) {}

    public function getCampaigns() : ?Collection
    {
        $user = auth('sanctum')->user();
        return $this->campaignsRepository->getCampaigns($user);
    }

    public function createCampaign(array $data) : Campaign
    {
        $newCampaign = $this->campaignsRepository->createCampaign($data);
        return $newCampaign;
    }

    public function updateCampaign(Campaign $campaign, array $data) : bool
    {
        return $this->campaignsRepository->updateCampaign($campaign, $data);
    }

    public function deleteCampaign(Campaign $campaign) : bool
    {
        return $this->campaignsRepository->deleteCampaign($campaign);
    }
}