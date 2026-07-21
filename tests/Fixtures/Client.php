<?php

namespace CodeTech\Vendus\Tests\Fixtures;

use CodeTech\Vendus\Contracts\VendusClient;
use CodeTech\Vendus\Traits\InteractsWithVendusClient;
use Illuminate\Database\Eloquent\Model;

class Client extends Model implements VendusClient
{
    use InteractsWithVendusClient;

    protected $guarded = [];

    protected $casts = [
        'price_group' => 'array',
    ];
}
