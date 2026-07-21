<?php

namespace CodeTech\Vendus\Traits;

use CodeTech\Vendus\Entities\VendusStock;

trait InteractsWithVendusProduct
{
    use VendusApiResource;

    /**
     * Returns the Vendus resource name.
     */
    public function getVendusResourceName(): string
    {
        return 'products';
    }

    public function getVendusReference(): string
    {
        return $this->reference ?? '';
    }

    public function getVendusExternalReference(): string
    {
        return $this->id ?? '';
    }

    public function getVendusBarcode(): string
    {
        return $this->barcode ?? '';
    }

    public function getVendusSupplierCode(): string
    {
        return $this->supplier_code ?? '';
    }

    public function getVendusTitle(): string
    {
        return $this->title ?? '';
    }

    public function getVendusDescription(): string
    {
        return $this->description ?? '';
    }

    public function getVendusIncludeDescription(): string
    {
        return $this->include_description ?? 'no';
    }

    public function getVendusSupplyPrice(): float
    {
        return (float) ($this->supply_price ?? 0);
    }

    public function getVendusGrossPrice(): float
    {
        return (float) ($this->gross_price ?? 0);
    }

    public function getVendusUnitId(): ?int
    {
        return $this->unit_id ?? null;
    }

    public function getVendusTypeId(): string
    {
        return $this->type_id ?? 'P';

    }

    /**
     * @return bool
     */
    public function getVendusStockControl(): int
    {
        return $this->stock_control ?? 0;

    }

    public function getVendusStockType(): string
    {
        return $this->stock_type ?? VendusStock::TYPE_T;

    }

    public function getVendusTaxId(): string
    {
        return $this->tax_id ?? '';

    }

    public function getVendusTaxExemption(): string
    {
        return $this->tax_exemption ?? '';

    }

    public function getVendusTaxExemptionLaw(): string
    {
        return $this->tax_exemption_law ?? '';

    }

    public function getVendusCategoryId(): ?int
    {
        return $this->category_id ?? null;

    }

    public function getVendusBrandId(): ?int
    {
        return $this->brand_id ?? null;

    }

    public function getVendusImage(): string
    {
        return $this->image ?? '';

    }

    public function getVendusStatus(): string
    {
        return $this->status ?? 'on';

    }

    public function getVendusPrices(): array
    {
        return $this->prices ?? [];

    }

    public function getVendusParams(): array
    {
        return [
            'reference' => $this->getVendusReference(),
            'barcode' => $this->getVendusBarcode(),
            'supplier_code' => $this->getVendusSupplierCode(),
            'title' => $this->getVendusTitle(),
            'description' => $this->getVendusDescription(),
            'include_description' => $this->getVendusIncludeDescription(),
            'supply_price' => $this->getVendusSupplyPrice(),
            'gross_price' => $this->getVendusGrossPrice(),
            'unit_id' => $this->getVendusUnitId(),
            'type_id' => $this->getVendusTypeId(),
            'stock_control' => $this->getVendusStockControl(),
            'stock_type' => $this->getVendusStockType(),
            'tax_id' => $this->getVendusTaxId(),
            'tax_exemption' => $this->getVendusTaxExemption(),
            'tax_exemption_law' => $this->getVendusTaxExemptionLaw(),
            'category_id' => $this->getVendusCategoryId(),
            'brand_id' => $this->getVendusBrandId(),
            'image' => $this->getVendusImage(),
            'status' => $this->getVendusStatus(),
            'prices' => $this->getVendusPrices(),
        ];
    }

    /**
     * Get the parameters to perform a search to find a matching resource in Vendus.
     */
    public function getVendusFindMatchParams(): array
    {
        return [
            'reference' => $this->getVendusExternalReference(),
        ];
    }
}
