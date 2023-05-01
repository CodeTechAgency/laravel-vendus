<?php

namespace CodeTech\Vendus\Entities;

class VendusItem
{
    const CREATE_ALLOWED_PARAMS = [
        'id',
        'reference',
        'gross_price',
        'supply_price',
        'qty',
        'type_id',
        'variant_id',
        'title',
        'unit_id',
        'category_id',
        'brand_id',
        'discount_amount',
        'discount_percentage',
        'stock_control',
        'stock_type',
        'tax_id',
        'tax_exemption',
        'tax_exemption_law',
        'tax_custom',
        'reference_document',
        'text',
        'serial',
    ];

}
