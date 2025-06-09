<?php

namespace App\Services;

use App\Jobs\ProcessProductImage;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Bus\Dispatcher;

class SpreadsheetService
{
    public function processSpreadsheet($filePath)
    {
        $products_data = app('importer')->import($filePath);

        foreach ($products_data as $row) {
            $validator = Validator::make($row, [
                'product_code' => 'required|unique:products,code',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                // Optionally, log validation errors or collect them
                continue;
            }

            $validatedData = $validator->validated();

            // Map spreadsheet 'product_code' to model 'code' attribute
            // and include other required fields.
            $product = Product::create([
                'code' => $validatedData['product_code'],
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'quantity' => $validatedData['quantity'],
            ]);
            // Explicitly resolve the dispatcher and dispatch the job
            // to ensure it uses the application's current bus instance (which should be faked in tests).
            app(Dispatcher::class)->dispatch(new ProcessProductImage($product));
        }
    }
}
