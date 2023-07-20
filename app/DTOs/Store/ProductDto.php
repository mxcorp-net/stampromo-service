<?php

namespace App\DTOs\Store;

use App\Models\Product;

class ProductDto
{
    public int $id;
    public string $name;
    public string $description;
    public mixed $colors;
    public mixed $family;
    public mixed $provider;
    public mixed $images;

    public function __construct(Product $product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->colors = $product->colors()->select('colors.id', 'colors.name', 'colors.hex')->get()->toArray();
        $this->family = $product->family()->select('families.id', 'families.name')->get()[0];
        $this->provider = $product->provider()->select('providers.id', 'providers.name')->get()[0];
    }
}
