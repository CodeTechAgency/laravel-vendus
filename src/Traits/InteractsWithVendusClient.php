<?php

namespace CodeTech\Vendus\Traits;

trait InteractsWithVendusClient
{
    use VendusApiResource;

    /**
     * Returns the Vendus resource name.
     *
     * @return string
     */
    public function getVendusResourceName(): string
    {
        return 'clients';
    }

    /**
     * @return string
     */
    public function getVendusFiscalId(): string
    {
        return $this->fiscal_id ?? '';
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
    public function getVendusName(): string
    {
        return $this->name ?? '';
    }

    /**
     * @return string
     */
    public function getVendusAddress(): string
    {
        return $this->address ?? '';
    }

    /**
     * @return string
     */
    public function getVendusCity(): string
    {
        return $this->city ?? '';
    }

    /**
     * @return string
     */
    public function getVendusPostalCode(): string
    {
        return $this->postal_code ?? '';
    }

    /**
     * @return string
     */
    public function getVendusPhone(): string
    {
        return $this->phone ?? '';
    }

    /**
     * @return string
     */
    public function getVendusMobile(): string
    {
        return $this->mobile ?? '';
    }

    /**
     * @return string
     */
    public function getVendusEmail(): string
    {
        return $this->email ?? '';
    }

    /**
     * @return string
     */
    public function getVendusWebsite(): string
    {
        return $this->website ?? '';
    }

    /**
     * @return string
     */
    public function getVendusCountry(): string
    {
        return $this->country ?? '';
    }

    /**
     * @return array
     */
    public function getVendusPriceGroup(): array
    {
        return $this->price_group ?? [];
    }

    /**
     * @return string
     */
    public function getVendusSendMail(): string
    {
        return $this->send_mail ?? 'no';
    }

    /**
     * @return string
     */
    public function getVendusIrsRetention(): string
    {
        return $this->irs_retention ?? '';
    }

    /**
     * @return string
     */
    public function getVendusStatus(): string
    {
        return $this->status ?? 'active';
    }

    /**
     * @return string
     */
    public function getVendusNotes(): string
    {
        return $this->notes ?? '';
    }

    /**
     * @return array
     */
    public function getVendusParams(): array
    {
        return [
            "fiscal_id" => $this->getVendusFiscalId(),
            "external_reference" => $this->getVendusExternalReference(),
            "name" => $this->getVendusName(),
            "address" => $this->getVendusAddress(),
            "city" => $this->getVendusCity(),
            "postalcode" => $this->getVendusPostalCode(),
            "phone" => $this->getVendusPhone(),
            "mobile" => $this->getVendusMobile(),
            "email" => $this->getVendusEmail(),
            "website" => $this->getVendusWebsite(),
            "country" => $this->getVendusCountry(),
            "price_group" => $this->getVendusPriceGroup(),
            "send_email" => $this->getVendusSendMail(),
            "irs_retention" => $this->getVendusIrsRetention(),
            "status" => $this->getVendusStatus(),
            "notes" => $this->getVendusNotes(),
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
            'external_reference' => $this->getVendusExternalReference()
        ];
    }
}
