<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\SpreadsheetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Mockery;

require_once __DIR__ . '/../../../task3.php';

class SpreadsheetServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the spreadsheet service skips invalid data
     */
    public function test_process_spreadsheet_skips_invalid_data()
    {
        // Mock the importer with valid and invalid data
        $importerMock = Mockery::mock();
        $importerMock->shouldReceive('import')->once()->andReturn([
            [
                // Valid data
                'product_code' => 'P001',
                'name' => 'Test Product One',
                'price' => 10.99,
                'quantity' => 10,
            ],
            [
                // Invalid data - missing product_code
                'name' => 'Product Missing Code',
                'price' => 5.99,
                'quantity' => 5,
            ],
            [
                // Invalid data - invalid quantity
                'product_code' => 'P002',
                'name' => 'Product Invalid Quantity',
                'price' => 12.99,
                'quantity' => 0, // Min is 1
            ],
            [
                // Valid data
                'product_code' => 'P003',
                'name' => 'Test Product Three',
                'price' => 15.99,
                'quantity' => 15,
            ],
        ]);
        app()->instance('importer', $importerMock);

        // Fake the job dispatch
        Bus::fake();

        $service = new SpreadsheetService();
        $service->processSpreadsheet('dummy.xlsx');

        // Assert only valid products are created
        $this->assertDatabaseHas('products', ['code' => 'P001']);
        $this->assertDatabaseHas('products', ['code' => 'P003']);
        
        // Assert invalid products are not created
        $this->assertDatabaseMissing('products', ['code' => 'P002']);
        
        // Assert jobs are dispatched only for valid products
        Bus::assertDispatched(\App\Jobs\ProcessProductImage::class, 2);
        
        // Assert total number of products
        $this->assertEquals(2, Product::count());
    }
}