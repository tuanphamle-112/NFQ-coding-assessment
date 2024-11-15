<?php

namespace App\Services\ItemServices;

use App\WolfShop\Item;
use App\Models\Item as ItemModel;
use App\Factories\QualityUpdaterFactory;

class WolfService
{
    private QualityUpdaterFactory $qualityUpdaterFactory;

    public function __construct(QualityUpdaterFactory $qualityUpdaterFactory)
    {
        $this->qualityUpdaterFactory = $qualityUpdaterFactory;
    }

    public function getItems(): array
    {
        // Query database and convert to Item instances
        $items = ItemModel::all()->map(function ($itemModel) {
            return new Item($itemModel->name, $itemModel->sell_in, $itemModel->quality);
        })->toArray();

        return $items;
    }

    public function updateQuality($item): bool
    {
        // Handle change sellIn and Quality base on difference kind of items
        $updater = $this->qualityUpdaterFactory->make($item);
        $updater->update($item);

        // Update Database
        $updated = ItemModel::where('name', $item->name)
            ->update([
                'sell_in' => $item->sellIn,
                'quality' => $item->quality
            ]);

        return $updated;
    }
}
