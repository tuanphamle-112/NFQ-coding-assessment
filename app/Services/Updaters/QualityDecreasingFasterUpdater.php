<?php

declare(strict_types=1);

namespace App\Services\Updaters;

use App\WolfShop\Item;
use App\Services\ItemServices\Contracts\QualityUpdaterInterface;;


class QualityDecreasingFasterUpdater implements QualityUpdaterInterface
{
    public function update(Item $item): void
    {
        // Decrease quality by 2
        $item->quality = max(0, $item->quality - 2);

        $item->sellIn -= 1;
    }
}
