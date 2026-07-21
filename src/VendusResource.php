<?php

namespace CodeTech\Vendus;

use CodeTech\Vendus\Contracts\VendusApiResource;
use CodeTech\Vendus\Http\VendusApi;
use InvalidArgumentException;

class VendusResource
{
    /**
     * @var VendusApiResource
     */
    public $resource;

    /**
     * @var VendusApi
     */
    protected $vendusApiClient;

    /**
     * VendusResource constructor.
     */
    public function __construct(VendusApiResource $resource)
    {
        $this->resource = $resource;

        $apiKey = config('vendus.api_key');

        if (! is_string($apiKey) || $apiKey === '') {
            throw new InvalidArgumentException(
                'The Vendus API key is not configured. Set the VENDUS_API_KEY environment variable.'
            );
        }

        $this->vendusApiClient = new VendusApi($apiKey, config('vendus.base_url'));
    }

    /**
     * Get a specified resource.
     *
     * @return mixed
     */
    public function find(array $params)
    {
        return $this->vendusApiClient->{$this->resource->getVendusResourceName()}()->find($this->resource->getVendusId(), $params);
    }

    /**
     * Get a listing of the resource.
     */
    public function get(array $params): array
    {
        return $this->vendusApiClient->{$this->resource->getVendusResourceName()}()->get($params);
    }

    /**
     * Creates an entity on Vendus.
     *
     * @throws \Exception
     */
    public function store(): array
    {
        // First, let's try to find the resource by its external reference. If a match is found, it means
        // the resource already exists in Vendus, but there is no local record matching its ID. If that
        // is the case, let's do an update. In the end, let's save the Vendus resource ID.
        try {
            $results = $this->get($this->resource->getVendusFindMatchParams());

            if (count($results)) {
                $result = $results[0];

                // Updates the Vendus resource ID locally
                $this->resource->setVendusId($result->id);

                $result = $this->update();
            } else {
                try {
                    $result = $this->vendusApiClient->{$this->resource->getVendusResourceName()}()->create($this->resource->getVendusParams());

                    // Updates the Vendus resource ID locally
                    $this->resource->setVendusId($result->id);
                } catch (\Exception $e) {
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return json_decode(json_encode($result), true);
    }

    /**
     * Updates an entity on Vendus.
     */
    public function update(): array
    {
        $resource = $this->vendusApiClient->{$this->resource->getVendusResourceName()}()->update($this->resource->getVendusId(), $this->resource->getVendusParams());

        return json_decode(json_encode($resource), true);
    }

    /**
     * Syncs an entity with Vendus.
     *
     * @throws \Exception
     */
    public function sync(): array
    {
        return $this->resource->getVendusId() === null ? $this->store() : $this->update();
    }

    /**
     * Get errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->vendusApiClient->getErrors();
    }
}
