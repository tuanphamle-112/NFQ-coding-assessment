<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item as ItemModel;
use App\Services\ItemServices\WolfService;
use App\Factories\QualityUpdaterFactory;
use App\Services\ItemServices\Contracts\QualityUpdaterInterface;
use App\WolfShop\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class WolfServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $wolfService;
    protected $qualityUpdaterFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->qualityUpdaterFactory = Mockery::mock(QualityUpdaterFactory::class);
        $this->wolfService = new WolfService($this->qualityUpdaterFactory);
    }

    public function testCanRetrieveItemsAsItemInstances()
    {
        ItemModel::factory()->create([
            'name' => 'Standard Item',
            'sell_in' => 10,
            'quality' => 20,
        ]);

        $items = $this->wolfService->getItems();

        $this->assertCount(1, $items);
        $this->assertInstanceOf(Item::class, $items[0]);
        $this->assertEquals('Standard Item', $items[0]->name);
        $this->assertEquals(10, $items[0]->sellIn);
        $this->assertEquals(20, $items[0]->quality);
    }

    public function testUpdatesItemQualityAndSellIn()
    {
        $itemModel = ItemModel::factory()->create([
            'name' => 'Standard Item',
            'sell_in' => 10,
            'quality' => 20,
        ]);

        $item = new Item('Standard Item', 10, 20);

        $updaterMock = Mockery::mock(QualityUpdaterInterface::class);
        $updaterMock->shouldReceive('update')->once()->with($item)->andReturnUsing(function ($item) {
            $item->sellIn--; // Simulate the change made by the real `update()` method
            $item->quality--;
        });

        $this->qualityUpdaterFactory->shouldReceive('make')->once()->with($item)->andReturn($updaterMock);

        $result = $this->wolfService->updateQuality($item);

        $this->assertTrue($result);

        // Refresh the itemModel to check if the sell_in and quality were updated correctly
        $itemModel->refresh();
        $this->assertEquals($item->sellIn, $itemModel->sell_in);
        $this->assertEquals($item->quality, $itemModel->quality);
    }

    public function testUploadsImageAndUpdatesImgUrl()
    {
        $itemModel = ItemModel::factory()->create([
            'name' => 'Test Item',
            'img_url' => null,
        ]);

        $image = UploadedFile::fake()->image('test.jpg');

        // Create a mock for the Cloudinary class
        $cloudinaryMock = Mockery::mock(Cloudinary::class);
        $cloudinaryMock->shouldReceive('uploadApi->upload')
            ->once()
            ->with($image->getRealPath(), ['folder' => 'items'])
            ->andReturn(['secure_url' => 'http://example.com/test.jpg']);

        // Use reflection to access the protected property in WolfService
        $reflection = new \ReflectionClass($this->wolfService);
        $property = $reflection->getProperty('cloudinary');
        $property->setAccessible(true);
        $property->setValue($this->wolfService, $cloudinaryMock);

        // Call the method and verify the result
        $result = $this->wolfService->uploadImage($image, $itemModel);

        $this->assertEquals('http://example.com/test.jpg', $itemModel->img_url);
        $this->assertArrayHasKey('url', $result);
        $this->assertArrayHasKey('item', $result);
        $this->assertEquals('http://example.com/test.jpg', $result['url']);
    }
}
