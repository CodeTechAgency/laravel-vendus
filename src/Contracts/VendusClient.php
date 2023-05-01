<?php

namespace CodeTech\Vendus\Contracts;

interface VendusClient extends VendusApiResource
{
    public function getVendusFiscalId(): string;

    public function getVendusExternalReference(): string;

    public function getVendusName(): string;

    public function getVendusAddress(): string;

    public function getVendusCity(): string;

    public function getVendusPostalCode(): string;

    public function getVendusPhone(): string;

    public function getVendusMobile(): string;

    public function getVendusEmail(): string;

    public function getVendusWebsite(): string;

    public function getVendusCountry(): string;

    public function getVendusPriceGroup(): array;

    public function getVendusSendMail(): string;

    public function getVendusIrsRetention(): string;

    public function getVendusStatus(): string;

    public function getVendusNotes(): string;

    public function getVendusDate(): string;
}
