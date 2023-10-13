<?php

namespace TriasClient\types\FPTF;

class FPTFStop
{
    public string $type;
    public string $id;
    public string $name;
    public ?FPTFLocation $location = null;

    public function __construct(string $id, string $name, ?FPTFLocation $location = null)
    {
        $this->type = "stop";
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
    }
}
