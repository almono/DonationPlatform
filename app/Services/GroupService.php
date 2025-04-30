<?php

namespace App\Services;

use App\Repositories\GroupRepository;
use Illuminate\Support\Collection;

class GroupService
{
    public function __construct(
        private GroupRepository $groupRepository
    ) {}

    public function getGroups() : ?Collection
    {
        return $this->groupRepository->getGroups();
    }
}