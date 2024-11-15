<?php

declare(strict_types=1);

namespace App\Services\ItemServices\Contracts;

use App\WolfShop\Item;

interface QualityUpdaterInterface
{
    public function update(Item $item): void;
}
