<?php

namespace App\Casts;

use App\Enums\TrackerType;
use App\TrackerConfigs\ClockifyConfig;
use App\TrackerConfigs\EverhourConfig;
use App\TrackerConfigs\MayvenConfig;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TrackerConfigCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $config = json_decode($value, true);

        return match($model->type) {
            TrackerType::Mayven => new MayvenConfig(...$config),
            TrackerType::Clockify => new ClockifyConfig(...$config),
            TrackerType::Everhour => new EverhourConfig(...$config),
            default => $config,
        };
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (is_object($value)) {
            $value = get_object_vars($value);
        }

        return json_encode($value);
    }
}
