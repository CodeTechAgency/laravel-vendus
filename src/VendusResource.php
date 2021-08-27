<?php

namespace Waap\Vendus;

use Waap\Vendus\Contracts\VendusApiResource;
use Waap\VendusApi\Api;

class VendusResource
{
    /**
     * @var VendusApiResource
     */
    public $resource;

    /**
     * @var Api
     */
    protected $vendusApiClient;


    /**
     * VendusResource constructor.
     *
     * @param VendusApiResource $resource
     */
    public function __construct(VendusApiResource $resource)
    {
        $this->resource = $resource;

        $this->vendusApiClient = new Api(config('vendus.api_key'));
    }

    /**
     * Get a specified resource.
     *
     * @param array $params
     * @return bool
     */
    public function find(array $params)
    {
        return $this->vendusApiClient->{$this->resource->getVendusResourceName()}->find($this->resource->getVendusId(), $params);
    }

    /**
     * Get a listing of the resource.
     *
     * @param array $params
     * @return array
     */
    public function get(array $params): array
    {
        return $this->vendusApiClient->{$this->resource->getVendusResourceName()}()->get($params);
    }

    /**
     * Creates an entity on Vendus.
     *
     * @return array
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
     *
     * @return array
     */
    public function update(): array
    {
        $resource = $this->vendusApiClient->{$this->resource->getVendusResourceName()}()->update($this->resource->getVendusId(), $this->resource->getVendusParams());

        return json_decode(json_encode($resource), true);
    }

    /**
     * Syncs an entity with Vendus.
     *
     * @return array
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
    public function getErrors(){
        return $this->vendusApiClient->getErrors();
    }
}
