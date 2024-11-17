<?php

namespace App\Services\ItemServices;

use App\WolfShop\Item;
use App\Models\Item as ItemModel;
use App\Factories\QualityUpdaterFactory;
use Cloudinary\Cloudinary;

class WolfService
{
    private QualityUpdaterFactory $qualityUpdaterFactory;
    protected Cloudinary $cloudinary;

    // Hardcoding credential
    const CLOUDINARY_URL = "cloudinary://647836991622118:lpYs6mUAthjpT1VyhI01mrVRw-g@dg0kreplt";

    public function __construct(QualityUpdaterFactory $qualityUpdaterFactory)
    {
        $this->qualityUpdaterFactory = $qualityUpdaterFactory;

        $this->cloudinary = new Cloudinary(self::CLOUDINARY_URL);
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

        // TO DO: Could add a repository layer for handling database works but out of time
        $updated = ItemModel::where('name', $item->name)
            ->update([
                'sell_in' => $item->sellIn,
                'quality' => $item->quality
            ]);

        return $updated;
    }

    public function uploadImage($image, ItemModel $item)
    {
        // Upload the image to Cloudinary
        $uploadedFileUrl = $this->cloudinary->uploadApi()->upload(
            $image->getRealPath(),
            ['folder' => 'items']
        );

        // Update the img_url field in the item record
        $item->img_url = $uploadedFileUrl['secure_url'];

        $item->save();

        return [
            'url' => $uploadedFileUrl['secure_url'],
            'item' => $item,
        ];
    }
}
