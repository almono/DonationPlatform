<?php

namespace App\Repositories;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;
use Illuminate\Support\Collection;

class SettingRepository implements SettingRepositoryInterface
{
    public function getApplicationSettings() : ?Collection
    {
        return Setting::all()->pluck('value', 'name');
    }

    public function updateApplicationSettings(string $key, string|int $value) : bool
    {
        $setting = Setting::where('name', $key)->first();
    
        if ($setting) {
            // If the setting exists, update the value
            $setting->value = $value;
            $setting->save();

            return true;
        }

        return false;
    }
}