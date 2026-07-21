<?php

namespace CodeTech\Vendus\Traits;

trait InteractsWithVendusClient
{
    use VendusApiResource;

    /**
     * Returns the Vendus resource name.
     */
    public function getVendusResourceName(): string
    {
        return 'clients';
    }

    public function getVendusFiscalId(): string
    {
        return $this->fiscal_id ?? '';
    }

    public function getVendusExternalReference(): string
    {
        return $this->id ?? '';
    }

    public function getVendusName(): string
    {
        return $this->name ?? '';
    }

    public function getVendusAddress(): string
    {
        return $this->address ?? '';
    }

    public function getVendusCity(): string
    {
        return $this->city ?? '';
    }

    public function getVendusPostalCode(): string
    {
        return $this->postal_code ?? '';
    }

    public function getVendusPhone(): string
    {
        return $this->phone ?? '';
    }

    public function getVendusMobile(): string
    {
        return $this->mobile ?? '';
    }

    public function getVendusEmail(): string
    {
        return $this->email ?? '';
    }

    public function getVendusWebsite(): string
    {
        return $this->website ?? '';
    }

    public function getVendusCountry(): string
    {
        return $this->country ?? '';
    }

    public function getVendusPriceGroup(): array
    {
        return $this->price_group ?? [];
    }

    public function getVendusSendMail(): string
    {
        return $this->send_mail ?? 'no';
    }

    public function getVendusIrsRetention(): string
    {
        return $this->irs_retention ?? '';
    }

    public function getVendusStatus(): string
    {
        return $this->status ?? 'active';
    }

    public function getVendusNotes(): string
    {
        return $this->notes ?? '';
    }

    public function getVendusParams(): array
    {
        return [
            'fiscal_id' => $this->getVendusFiscalId(),
            'external_reference' => $this->getVendusExternalReference(),
            'name' => $this->getVendusName(),
            'address' => $this->getVendusAddress(),
            'city' => $this->getVendusCity(),
            'postalcode' => $this->getVendusPostalCode(),
            'phone' => $this->getVendusPhone(),
            'mobile' => $this->getVendusMobile(),
            'email' => $this->getVendusEmail(),
            'website' => $this->getVendusWebsite(),
            'country' => $this->getVendusCountry(),
            'price_group' => $this->getVendusPriceGroup(),
            'send_email' => $this->getVendusSendMail(),
            'irs_retention' => $this->getVendusIrsRetention(),
            'status' => $this->getVendusStatus(),
            'notes' => $this->getVendusNotes(),
        ];
    }

    /**
     * Get the parameters to perform a search to find a matching resource in Vendus.
     */
    public function getVendusFindMatchParams(): array
    {
        return [
            'external_reference' => $this->getVendusExternalReference(),
        ];
    }
}
