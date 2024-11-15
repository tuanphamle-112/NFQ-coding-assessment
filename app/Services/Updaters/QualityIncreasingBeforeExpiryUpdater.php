<?php

declare(strict_types=1);

namespace App\Services\Updaters;

use App\WolfShop\Item;
use App\Services\ItemServices\Contracts\QualityUpdaterInterface;;


class QualityIncreasingBeforeExpiryUpdater implements QualityUpdaterInterface
{
    public function update(Item $item): void
    {
        // Apple Ipad Airs
        if ($item->quality < 50) {
            $item->quality += 1;

            if ($item->sellIn <= 10) {
                // Increase 1 more when there are 10 day or less
                $item->quality = min(50, $item->quality + 1);
            }

            if ($item->sellIn <= 5) {
                // Increase 1 more when there are 5 day or less
                $item->quality = min(50, $item->quality + 1);
            }
        }

        $item->sellIn -= 1;

        if ($item->sellIn < 0) {
            // Drops to 0 once out of date
            $item->quality = 0;
        }
    }
}
