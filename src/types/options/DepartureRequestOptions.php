<?php

namespace TriasClient\types\options;

use \DateTime;

class DepartureRequestOptions
{
    public string $id;
    public ?DateTime $time = null;
    public ?int $maxResults = null;
    public ?bool $includeSituations = null;

    public function setId(string $id): DepartureRequestOptions
    {
        $this->id = $id;
        return $this;
    }

    public function setTime(DateTime|string $time): DepartureRequestOptions
    {
        $this->time = $time instanceof DateTime ? $time : new DateTime($time);
        return $this;
    }

    public function setMaxResults(?int $maxResults): DepartureRequestOptions
    {
        $this->maxResults = $maxResults;
        return $this;
    }

    public function setIncludeSituations(?bool $includeSituations): DepartureRequestOptions
    {
        $this->includeSituations = $includeSituations;
        return $this;
    }
}
