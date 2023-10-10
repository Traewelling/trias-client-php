<?php

declare(strict_types=1);

namespace TriasClient\types;

class StopsRequestOptions
{
    public ?string $name = null;
    public ?float $latitude = null;
    public ?float $longitude = null;
    public ?int $radius = null;
    public ?int $maxResults = null;

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function setRadius($radius)
    {
        $this->radius = $radius;
        return $this;
    }

    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
        return $this;
    }


}
