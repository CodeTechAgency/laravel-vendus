<?php

namespace CodeTech\Vendus\Contracts;

interface VendusProduct extends VendusApiResource
{
    public function getVendusReference(): string;

    public function getVendusBarcode(): string;

    public function getVendusSupplierCode(): string;

    public function getVendusTitle(): string;

    public function getVendusDescription(): string;

    public function getVendusIncludeDescription(): string;

    public function getVendusSupplyPrice(): float;

    public function getVendusGrossPrice(): float;

    public function getVendusUnitId(): ?int;

    public function getVendusTypeId(): string;

    public function getVendusStockControl(): int;

    public function getVendusStockType(): string;

    public function getVendusTaxId(): string;

    public function getVendusTaxExemption(): string;

    public function getVendusTaxExemptionLaw(): string;

    public function getVendusCategoryId(): ?int;

    public function getVendusBrandId(): ?int;

    public function getVendusImage(): string;

    public function getVendusStatus(): string;

    public function getVendusPrices(): array;
}
