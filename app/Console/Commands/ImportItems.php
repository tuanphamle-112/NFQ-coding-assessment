<?php

namespace App\Console\Commands;

use App\Constants\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Item as ItemModel;

class ImportItems extends Command
{
    protected $signature = 'items:import';
    protected $description = 'Import items from external API and update inventory';

    // API URL
    private const API_URL = Item::ITEM_GET_ITEMS_API_URL;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Fetching items from API...');

        // Make an HTTP GET request to fetch the data
        $response = Http::get(self::API_URL);

        if ($response->successful()) {
            $apiItems = $response->json();
            $defaultSellIn = Item::ITEM_SELL_IN_DEFAULT;
            $defaultQuality = Item::ITEM_QUALITY_DEFAULT;

            foreach ($apiItems as $apiItem) {
                $item = ItemModel::firstOrNew(['name' => $apiItem['name']]);

                if (!$item->exists) {
                    $item->sell_in = $defaultSellIn;
                    $item->quality = $defaultQuality;
                } else {
                    $item->quality += 1;
                }

                $item->save();

                $this->info("Processed item: {$apiItem['name']}");
            }

            $this->info("Items import completed successfully.");
        } else {
            $this->error("Failed to fetch data from the API.");
        }
    }
}
