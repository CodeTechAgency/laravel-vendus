<?php

namespace Waap\Vendus\Entities;

class VendusSalesDocument
{
    const TYPE_FT = 'FT';
    const TYPE_FS = 'FS';
    const TYPE_FR = 'FR';
    const TYPE_NC = 'NC';
    const TYPE_DC = 'DC';
    const TYPE_PF = 'PF';
    const TYPE_OT = 'OT';
    const TYPE_EC = 'EC';
    const TYPE_GA = 'GA';
    const TYPE_GT = 'GT';
    const TYPE_GR = 'GR';
    const TYPE_GD = 'GD';
    const TYPE_RG = 'RG';

    const OUTPUT_PDF = 'pdf';
    const OUTPUT_ESCPOS = 'escpos';
    const OUTPUT_HTML = 'html';

    const CREATE_ALLOWED_PARAMS = [
        'register_id',
        'type',
        'discount_code',
        'discount_amount',
        'discount_percentage',
        'date_due',
        'payments',
        'mode',
        'date',
        'date_supply',
        'notes',
        'external_reference',
        'stock_operation',
        'ifthenpay',
        'eupago',
        'multibanco',
        'client',
        'supplier',
        'items',
        'movement_of_goods',
        'invoices',
        'print_discount',
        'output',
        'output_template_id',
        'tx_id',
        'errors_full',
        'rest_room',
        'rest_table',
        'occupation',
        'stamp_retention_amount',
        'related_document_id',
        'return_qrcode',
    ];

}
