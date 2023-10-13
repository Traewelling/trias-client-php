<?php

namespace TriasClient\types\FPTF;

class Situation
{
    public string $title;
    public string $description;
    public string $validFrom;
    public string $validto;
    public string $priority;

    public function __construct(
        string $title,
        string $description,
        string $validFrom,
        string $validto,
        string $priority
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->validFrom = $validFrom;
        $this->validto = $validto;
        $this->priority = $priority;
    }


}
