<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use App\Repositories\SettingRepository;
use Illuminate\Support\Collection;

class SettingsService
{
    public function __construct(
        private SettingRepository $settingRepository
    ) {}

    public function getApplicationSettings() : ?Collection
    {
        return $this->settingRepository->getApplicationSettings();
    }

    public function updateApplicationSettings(array $data) : array
    {
        $updateResults = [];

        foreach ($data as $key => $value) {
            $updatedSettings = $this->settingRepository->updateApplicationSettings($key, $value);

            if(!$updatedSettings) {
                $updateResults[] = "Setting with key {$key} failed to update";
            }
        }

        return $updateResults;
    }
}