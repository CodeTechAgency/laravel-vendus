<?php

namespace Waap\Vendus\Contracts;

interface VendusApiResource
{
    public function getVendusId(): ?int;

    public function setVendusId(int $vendusId): void;

    public function getVendusResourceName(): string;

    public function getVendusParams(): array;

    public function getVendusFindMatchParams(): array;
}
