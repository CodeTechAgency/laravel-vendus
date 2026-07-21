<?php

use CodeTech\Vendus\Entities\VendusStock;
use CodeTech\Vendus\Tests\Fixtures\Product;

it('maps model attributes to vendus product params', function () {
    $product = new Product([
        'reference' => 'SKU-1',
        'barcode' => '5601234567890',
        'supplier_code' => 'SUP-9',
        'title' => 'Vinho Tinto',
        'description' => 'Douro DOC',
        'include_description' => 'yes',
        'supply_price' => '3.50',
        'gross_price' => '9.99',
        'unit_id' => 4,
        'type_id' => 'P',
        'stock_control' => 1,
        'stock_type' => VendusStock::TYPE_M,
        'tax_id' => 'NOR',
        'tax_exemption' => 'M07',
        'tax_exemption_law' => 'Artigo 9',
        'category_id' => 2,
        'brand_id' => 3,
        'image' => 'https://example.com/wine.jpg',
        'status' => 'on',
        'prices' => [['group_id' => 1, 'price' => 8.5]],
    ]);

    expect($product->getVendusParams())->toEqual([
        'reference' => 'SKU-1',
        'barcode' => '5601234567890',
        'supplier_code' => 'SUP-9',
        'title' => 'Vinho Tinto',
        'description' => 'Douro DOC',
        'include_description' => 'yes',
        'supply_price' => 3.5,
        'gross_price' => 9.99,
        'unit_id' => 4,
        'type_id' => 'P',
        'stock_control' => 1,
        'stock_type' => 'M',
        'tax_id' => 'NOR',
        'tax_exemption' => 'M07',
        'tax_exemption_law' => 'Artigo 9',
        'category_id' => 2,
        'brand_id' => 3,
        'image' => 'https://example.com/wine.jpg',
        'status' => 'on',
        'prices' => [['group_id' => 1, 'price' => 8.5]],
    ]);
});

it('returns the prices attribute from getVendusPrices', function () {
    // Regression: this used to read a non-existent `s` property and always
    // returned an empty array, so price groups were never sent to Vendus.
    $product = new Product(['prices' => [['group_id' => 1, 'price' => 8.5]]]);

    expect($product->getVendusPrices())->toBe([['group_id' => 1, 'price' => 8.5]]);
});

it('casts string price attributes to float', function () {
    $product = new Product(['supply_price' => '12.50', 'gross_price' => '19.90']);

    expect($product->getVendusSupplyPrice())->toBe(12.5)
        ->and($product->getVendusGrossPrice())->toBe(19.9);
});

it('applies sensible defaults for missing product attributes', function () {
    $params = (new Product)->getVendusParams();

    expect($params['include_description'])->toBe('no')
        ->and($params['supply_price'])->toBe(0.0)
        ->and($params['gross_price'])->toBe(0.0)
        ->and($params['type_id'])->toBe('P')
        ->and($params['stock_control'])->toBe(0)
        ->and($params['stock_type'])->toBe(VendusStock::TYPE_T)
        ->and($params['status'])->toBe('on')
        ->and($params['prices'])->toBe([]);
});

it('matches existing vendus products by reference', function () {
    $product = new Product;
    $product->id = 12;

    expect($product->getVendusFindMatchParams())->toBe(['reference' => '12']);
});

it('uses the products resource name', function () {
    expect((new Product)->getVendusResourceName())->toBe('products');
});
