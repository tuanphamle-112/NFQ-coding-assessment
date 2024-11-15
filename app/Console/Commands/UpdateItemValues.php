<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ItemServices\WolfService;
use Illuminate\Support\Facades\Log;

class UpdateItemValues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:update-values';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates sellIn and quality values for all items';

    protected WolfService $wolfService;

    public function __construct(WolfService $wolfService)
    {
        parent::__construct();
        $this->wolfService = $wolfService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Fetch all items from the database
            $items = $this->wolfService->getItems();

            // Call the WolfService to update quality and sellIn for each item
            foreach ($items as $item) {
                $this->wolfService->updateQuality($item);
            }

            $this->info('Daily update of item values complete.');
        } catch (\Exception $e) {
            Log::error('Error updating item values: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            $this->error('An error occurred while updating item values. Please check the logs for more details.');
        }
    }
}
