<?php

namespace App\Interfaces;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Collection;

interface CampaignsRepositoryInterface
{
    public function getCampaigns(?User $user) : ?Collection;
    public function createCampaign(array $data) : Campaign;
    public function updateCampaign(Campaign $campaign, array $data) : bool;
    public function deleteCampaign(Campaign $campaign) : bool;
}
