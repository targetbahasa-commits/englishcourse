<?php

namespace App\Infrastructure\Setting;

use App\Domain\Setting\Repositories\SettingRepository;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class EloquentSettingRepository implements SettingRepository
{
    public function getAllAsKeyValue(): array
    {
        return Setting::all()->pluck('value', 'key')->toArray();
    }

    public function bulkUpdate(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget('app_settings');
    }
}
