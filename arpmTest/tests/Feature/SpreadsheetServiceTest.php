<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\SpreadsheetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Mockery;

require_once __DIR__ . '/../../../task3.php';

class SpreadsheetServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Note: The processSpreadsheet method expects a 'code' field in the products table, but the migration does not define this field. This may cause tests to fail or the application to throw errors. Please ensure the schema matches the code logic.
     */
    public function test_process_spreadsheet_creates_products_and_dispatches_jobs()
    {
        // Mock the importer
        $importerMock = Mockery::mock();
        $importerMock->shouldReceive('import')->once()->andReturn([
            [
                'code' => 'P001',
                'quantity' => 10,
            ],
            [
                'code' => 'P002',
                'quantity' => 5,
            ],
        ]);
        app()->instance('importer', $importerMock);

        // Fake the job dispatch
        Bus::fake();

        $service = new SpreadsheetService();
        $service->processSpreadsheet('dummy.xlsx');

        // Assert products are created
        $this->assertDatabaseHas('products', ['code' => 'P001']);
        $this->assertDatabaseHas('products', ['code' => 'P002']);

        // Assert jobs are dispatched
        Bus::assertDispatched(\App\Jobs\ProcessProductImage::class, 2);
    }
}