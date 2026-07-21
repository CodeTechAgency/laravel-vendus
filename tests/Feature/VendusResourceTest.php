<?php

use CodeTech\Vendus\Contracts\VendusApiResource;
use CodeTech\Vendus\VendusResource;

function fakeVendusApiResource(): VendusApiResource
{
    return new class implements VendusApiResource
    {
        public function getVendusId(): ?int
        {
            return null;
        }

        public function setVendusId(int $vendusId): void
        {
        }

        public function getVendusResourceName(): string
        {
            return 'clients';
        }

        public function getVendusParams(): array
        {
            return [];
        }

        public function getVendusFindMatchParams(): array
        {
            return [];
        }
    };
}

it('throws a clear exception when the api key is not configured', function () {
    config()->set('vendus.api_key', null);

    new VendusResource(fakeVendusApiResource());
})->throws(InvalidArgumentException::class, 'The Vendus API key is not configured.');

it('throws a clear exception when the api key is an empty string', function () {
    config()->set('vendus.api_key', '');

    new VendusResource(fakeVendusApiResource());
})->throws(InvalidArgumentException::class);
