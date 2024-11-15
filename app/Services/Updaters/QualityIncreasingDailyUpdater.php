<?php

declare(strict_types=1);

namespace App\Services\Updaters;

use App\WolfShop\Item;
use App\Services\ItemServices\Contracts\QualityUpdaterInterface;;


class QualityIncreasingDailyUpdater implements QualityUpdaterInterface
{
    public function update(Item $item): void
    {
        // Increment quality by 1 daily, up to a maximum of 50
        $item->quality = min(50, $item->quality + 1);

        $item->sellIn -= 1;
    }
}
