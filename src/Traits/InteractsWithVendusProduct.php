<?php

namespace Waap\Vendus\Traits;

use Waap\Vendus\Entities\VendusStock;

trait InteractsWithVendusProduct
{
    use VendusApiResource;

    /**
     * Returns the Vendus resource name.
     *
     * @return string
     */
    public function getVendusResourceName(): string
    {
        return 'products';
    }

    /**
     * @return string
     */
    public function getVendusReference(): string
    {
        return $this->reference ?? '';
    }

    /**
     * @return string
     */
    public function getVendusExternalReference(): string
    {
        return $this->id ?? '';
    }

    /**
     * @return string
     */
    public function getVendusBarcode(): string
    {
        return $this->barcode ?? '';
    }

    /**
     * @return string
     */
    public function getVendusSupplierCode(): string
    {
        return $this->supplier_code ?? '';
    }

    /**
     * @return string
     */
    public function getVendusTitle(): string
    {
        return $this->title ?? '';
    }

    /**
     * @return string
     */
    public function getVendusDescription(): string
    {
        return $this->description ?? '';
    }

    /**
     * @return string
     */
    public function getVendusIncludeDescription(): string
    {
        return $this->include_description ?? 'no';
    }

    /**
     * @return float
     */
    public function getVendusSupplyPrice(): float
    {
        return $this->supply_price ?? '';
    }

    /**
     * @return float
     */
    public function getVendusGrossPrice(): float
    {
        return $this->gross_price ?? '';
    }

    /**
     * @return int
     */
    public function getVendusUnitId(): ?int
    {
        return $this->unit_id ?? null;
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    public function getVendusStockType(): string
    {
        return $this->stock_type ?? VendusStock::TYPE_T;

    }

    /**
     * @return string
     */
    public function getVendusTaxId(): string
    {
        return $this->tax_id ?? '';

    }

    /**
     * @return string
     */
    public function getVendusTaxExemption(): string
    {
        return $this->tax_exemption ?? '';

    }

    /**
     * @return string
     */
    public function getVendusTaxExemptionLaw(): string
    {
        return $this->tax_exemption_law ?? '';

    }

    /**
     * @return int
     */
    public function getVendusCategoryId(): ?int
    {
        return $this->category_id ?? null;

    }

    /**
     * @return int|null
     */
    public function getVendusBrandId(): ?int
    {
        return $this->brand_id ?? null;

    }

    /**
     * @return string
     */
    public function getVendusImage(): string
    {
        return $this->image ?? '';

    }

    /**
     * @return string
     */
    public function getVendusStatus(): string
    {
        return $this->status ?? 'on';

    }

    /**
     * @return array
     */
    public function getVendusPrices(): array
    {
        return $this->s ?? [];

    }

    /**
     * @return array
     */
    public function getVendusParams(): array
    {
        return [
            "reference" => $this->getVendusReference(),
            "barcode" => $this->getVendusBarcode(),
            "supplier_code" => $this->getVendusSupplierCode(),
            "title" => $this->getVendusTitle(),
            "description" => $this->getVendusDescription(),
            "include_description" => $this->getVendusIncludeDescription(),
            "supply_price" => $this->getVendusSupplyPrice(),
            "gross_price" => $this->getVendusGrossPrice(),
            "unit_id" => $this->getVendusUnitId(),
            "type_id" => $this->getVendusTypeId(),
            "stock_control" => $this->getVendusStockControl(),
            "stock_type" => $this->getVendusStockType(),
            "tax_id" => $this->getVendusTaxId(),
            "tax_exemption" => $this->getVendusTaxExemption(),
            "tax_exemption_law" => $this->getVendusTaxExemptionLaw(),
            "category_id" => $this->getVendusCategoryId(),
            "brand_id" => $this->getVendusBrandId(),
            "image" => $this->getVendusImage(),
            "status" => $this->getVendusStatus(),
            "prices" => $this->getVendusPrices(),
        ];
    }

    /**
     * Get the parameters to perform a search to find a matching resource in Vendus.
     *
     * @return array
     */
    public function getVendusFindMatchParams(): array
    {
        return [
            'reference' => $this->getVendusExternalReference()
        ];
    }
}
