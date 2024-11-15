<?php

declare(strict_types=1);

namespace App\Services\Updaters;

use App\WolfShop\Item;
use App\Services\ItemServices\Contracts\QualityUpdaterInterface;

class QualityConstantUpdater implements QualityUpdaterInterface
{
    public function update(Item $item): void
    {
        // Samsung Galaxy S23 items do not decrease in quality
        $item->sellIn -= 1;
    }
}
