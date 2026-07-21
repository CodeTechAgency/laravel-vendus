<?php

namespace CodeTech\Vendus\Traits;

trait VendusApiResource
{
    /**
     * Returns the Vendus resource ID.
     */
    public function getVendusId(): ?int
    {
        return $this->vendus_id;
    }

    /**
     * Sets the Vendus resource ID.
     */
    public function setVendusId(int $vendusId): void
    {
        $this->vendus_id = $vendusId;
        $this->save();
    }

    /**
     * Returns the Vendus resource date.
     */
    public function getVendusDate(): string
    {
        return $this->date;
    }

    /**
     * Return the link to the resource's detail page in the Vendus app.
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    public function getDetailPageLink()
    {
        return sprintf(
            '%s/%s/detail/id/%s',
            config('vendus.app_url'),
            $this->getVendusResourceName(),
            $this->getVendusId()
        );
    }
}
