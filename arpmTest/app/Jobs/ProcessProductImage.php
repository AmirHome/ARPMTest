<?php

namespace App\Jobs;

use App\Models\Product;

class ProcessProductImage
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public static function dispatch(Product $product)
    {
        // Stub for dispatching the job
    }
}