<?php

namespace CodeTech\Vendus\Http;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Endpoint
{
    public function __construct(
        protected VendusApi $api,
        protected string $uri
    ) {}

    /**
     * Find the specified resource.
     *
     * @return mixed|null
     */
    public function find(int $id, array $params = []): mixed
    {
        try {
            $response = $this->request()
                ->get($this->uri.'/'.$id, array_merge($this->api->getDefaultQueryParams(), $params))
                ->throw();
        } catch (RequestException $exception) {
            $this->handleException($exception);

            return null;
        }

        return $response->object();
    }

    /**
     * Get a list of the specified resource.
     */
    public function get(array $params = []): mixed
    {
        try {
            $response = $this->request()
                ->get($this->uri, array_merge($this->api->getDefaultQueryParams(), $params))
                ->throw();
        } catch (RequestException $exception) {
            $this->handleException($exception);

            return [];
        }

        return $response->object();
    }

    /**
     * Get a paginated list of the specified resource.
     */
    public function paginate(array $params, int $page, int $perPage): array
    {
        $params['page'] = $page;
        $params['per_page'] = $perPage;

        try {
            $response = $this->request()
                ->get($this->uri, array_merge($this->api->getDefaultQueryParams(), $params))
                ->throw();
        } catch (RequestException $exception) {
            $this->handleException($exception);

            return [
                'data' => [],
                'total' => 0,
            ];
        }

        return [
            'data' => $response->object(),
            'total' => (int) $response->header('X-Paginator-Items'),
        ];
    }

    /**
     * Creates a new resource.
     *
     * @throws RequestException
     */
    public function create(array $params = []): mixed
    {
        try {
            $response = $this->request()
                ->withQueryParameters($this->api->getDefaultQueryParams())
                ->asForm()
                ->post($this->uri, $params)
                ->throw();
        } catch (RequestException $exception) {
            $this->handleException($exception);

            throw $exception;
        }

        return $response->object();
    }

    /**
     * Updates the specified resource.
     *
     * @throws RequestException
     */
    public function update(int $id, array $params = []): mixed
    {
        try {
            $response = $this->request()
                ->withQueryParameters($this->api->getDefaultQueryParams())
                ->asForm()
                ->patch($this->uri.'/'.$id, $params)
                ->throw();
        } catch (RequestException $exception) {
            $this->handleException($exception);

            throw $exception;
        }

        return $response->object();
    }

    /**
     * A pending request against the configured Vendus API base URL.
     */
    private function request(): PendingRequest
    {
        return Http::baseUrl($this->api->getBaseUrl());
    }

    /**
     * Handles an exception by setting the error messages on the api instance.
     */
    private function handleException(RequestException $exception): void
    {
        $errors = $exception->response->object()?->errors ?? [];

        $messages = [];

        foreach ($errors as $key => $error) {
            $messages[$key] = $error->code.': '.$error->message;
        }

        $this->api->setErrors($messages);
    }
}
