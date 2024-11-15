<?php

declare(strict_types=1);

namespace App\Factories;

use App\WolfShop\Item;
use App\Services\Updaters\NormalItemUpdater;
use App\Services\Updaters\QualityIncreasingDailyUpdater;
use App\Services\Updaters\QualityConstantUpdater;
use App\Services\Updaters\QualityDecreasingFasterUpdater;
use App\Services\Updaters\QualityIncreasingBeforeExpiryUpdater;
use App\Services\ItemServices\Contracts\QualityUpdaterInterface;

class QualityUpdaterFactory
{
    public function make(Item $item): QualityUpdaterInterface
    {
        // Would be better if the requirement used type to classify the items.
        return match ($item->name) {
            'Apple AirPods' => new QualityIncreasingDailyUpdater(),
            'Samsung Galaxy S23' => new QualityConstantUpdater(),
            'Apple iPad Air' => new QualityIncreasingBeforeExpiryUpdater(),
            'Xiaomi Redmi Note 13' => new QualityDecreasingFasterUpdater(),
            default => new NormalItemUpdater(),
        };
    }
}
