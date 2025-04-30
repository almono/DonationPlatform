<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface GroupRepositoryInterface
{
    public function getGroups() : ?Collection;
}
