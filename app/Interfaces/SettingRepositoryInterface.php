<?php

namespace App\Interfaces;

use App\Models\Setting;
use Illuminate\Support\Collection;

interface SettingRepositoryInterface
{
    public function getApplicationSettings() : ?Collection;
    public function updateApplicationSettings(string $key, string|int $value) : bool;
}
