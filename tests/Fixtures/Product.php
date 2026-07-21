<?php

namespace CodeTech\Vendus\Tests\Fixtures;

use CodeTech\Vendus\Contracts\VendusProduct;
use CodeTech\Vendus\Traits\InteractsWithVendusProduct;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements VendusProduct
{
    use InteractsWithVendusProduct;

    protected $guarded = [];

    protected $casts = [
        'prices' => 'array',
    ];
}
