<?php

namespace App\Repositories;

use App\Interfaces\GroupRepositoryInterface;
use App\Models\Group;
use Illuminate\Support\Collection;

class GroupRepository implements GroupRepositoryInterface
{
    public function getGroups() : ?Collection
    {
        return Group::all();
    }
}