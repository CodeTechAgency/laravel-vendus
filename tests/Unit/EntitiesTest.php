<?php

use CodeTech\Vendus\Entities\VendusItem;
use CodeTech\Vendus\Entities\VendusSalesDocument;
use CodeTech\Vendus\Entities\VendusStock;
use CodeTech\Vendus\Entities\VendusTax;

it('defines the sales document types', function () {
    expect(VendusSalesDocument::TYPE_FT)->toBe('FT')
        ->and(VendusSalesDocument::TYPE_FS)->toBe('FS')
        ->and(VendusSalesDocument::TYPE_FR)->toBe('FR')
        ->and(VendusSalesDocument::TYPE_NC)->toBe('NC')
        ->and(VendusSalesDocument::TYPE_DC)->toBe('DC')
        ->and(VendusSalesDocument::TYPE_PF)->toBe('PF')
        ->and(VendusSalesDocument::TYPE_OT)->toBe('OT')
        ->and(VendusSalesDocument::TYPE_EC)->toBe('EC')
        ->and(VendusSalesDocument::TYPE_GA)->toBe('GA')
        ->and(VendusSalesDocument::TYPE_GT)->toBe('GT')
        ->and(VendusSalesDocument::TYPE_GR)->toBe('GR')
        ->and(VendusSalesDocument::TYPE_GD)->toBe('GD')
        ->and(VendusSalesDocument::TYPE_RG)->toBe('RG');
});

it('defines the sales document output formats', function () {
    expect(VendusSalesDocument::OUTPUT_PDF)->toBe('pdf')
        ->and(VendusSalesDocument::OUTPUT_ESCPOS)->toBe('escpos')
        ->and(VendusSalesDocument::OUTPUT_HTML)->toBe('html');
});

it('whitelists the sales document creation params', function () {
    expect(VendusSalesDocument::CREATE_ALLOWED_PARAMS)
        ->toBeArray()
        ->toContain('register_id', 'type', 'date', 'client', 'items', 'payments', 'output', 'external_reference');
});

it('whitelists the item creation params', function () {
    expect(VendusItem::CREATE_ALLOWED_PARAMS)
        ->toBeArray()
        ->toContain('id', 'reference', 'qty', 'gross_price', 'tax_id', 'discount_percentage');
});

it('defines the stock types', function () {
    expect(VendusStock::TYPE_M)->toBe('M')
        ->and(VendusStock::TYPE_P)->toBe('P')
        ->and(VendusStock::TYPE_A)->toBe('A')
        ->and(VendusStock::TYPE_S)->toBe('S')
        ->and(VendusStock::TYPE_T)->toBe('T');
});

it('defines the portuguese tax rate codes', function () {
    expect(VendusTax::TAX_NOR)->toBe('NOR')
        ->and(VendusTax::TAX_INT)->toBe('INT')
        ->and(VendusTax::TAX_RED)->toBe('RED')
        ->and(VendusTax::TAX_ISE)->toBe('ISE')
        ->and(VendusTax::TAX_OUT)->toBe('OUT');
});
