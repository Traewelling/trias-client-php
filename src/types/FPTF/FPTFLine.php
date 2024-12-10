<?php

namespace TriasClient\types\FPTF;

class FPTFLine
{
    public string $type;
    public string $id;
    public string $line;
    public string $longName;

    public function __construct(string $id, string $longName, string $line)
    {
        $this->type = "line";
        $this->id = $id;
        $this->line = $line;
        $this->longName = $longName;
    }
}
