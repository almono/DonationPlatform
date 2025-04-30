<?php

namespace App\Repositories;

use App\Enums\UserRoles;
use App\Interfaces\CampaignsRepositoryInterface;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Collection;

class CampaignsRepository implements CampaignsRepositoryInterface
{
    public function getCampaigns(?User $user) : ?Collection
    {
        $campaigns = Campaign::withSum('donations', 'amount')->get();

        // If the user is not an admin and has assigned group then return only campaigns for the given group
        if($user?->role !== UserRoles::ADMIN_ROLE && !is_null($user?->group_id)) {
            $campaigns->where('group_id', $user->group_id);
        }

        $campaigns->each(function ($campaign) {
            // To round the results just in case
            $campaign->donations_sum_amount = round($campaign->donations_sum_amount, 2);
        });

        return $campaigns;
    }

    public function createCampaign(array $data) : Campaign
    {
        return Campaign::create($data);
    }

    public function updateCampaign(Campaign $campaign, array $data) : bool
    {
        return $campaign->update($data);
    }

    public function deleteCampaign(Campaign $campaign) : bool
    {
        return $campaign->delete();
    }
}