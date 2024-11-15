<?php

declare(strict_types=1);

namespace App\Services\Updaters;

use App\WolfShop\Item;
use App\Services\ItemServices\Contracts\QualityUpdaterInterface;;


class NormalItemUpdater implements QualityUpdaterInterface
{
    public function update(Item $item): void
    {
        $item->quality = max(0, $item->quality - 1);

        $item->sellIn -= 1;

        if ($item->sellIn < 0) {
            $item->quality = max(0, $item->quality - 1);
        }
    }
}
