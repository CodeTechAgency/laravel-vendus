<?php

namespace CodeTech\Vendus\Http;

class VendusApi
{
    /**
     * The error messages.
     *
     * @var array
     */
    private array $errors = [];

    public function __construct(
        protected string $apiKey,
        protected string $baseUrl = 'https://www.vendus.pt/ws/v1.1/'
    ) {
    }

    /**
     * Get the clients endpoint.
     */
    public function clients(): Endpoint
    {
        return new Endpoint($this, 'clients');
    }

    /**
     * Get the products endpoint.
     */
    public function products(): Endpoint
    {
        return new Endpoint($this, 'products');
    }

    /**
     * Get the product units endpoint.
     */
    public function units(): Endpoint
    {
        return new Endpoint($this, 'products/units');
    }

    /**
     * Get the documents endpoint.
     */
    public function documents(): Endpoint
    {
        return new Endpoint($this, 'documents');
    }

    /**
     * Get the payment methods endpoint.
     */
    public function paymentMethods(): Endpoint
    {
        return new Endpoint($this, 'documents/paymentmethods');
    }

    /**
     * The base URL of the Vendus API.
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * The query parameters that must be sent on every request.
     */
    public function getDefaultQueryParams(): array
    {
        return [
            'api_key' => $this->apiKey,
        ];
    }

    /**
     * Get the errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Set the errors.
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
