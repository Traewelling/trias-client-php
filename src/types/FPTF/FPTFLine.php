<?php

namespace TriasClient\types\FPTF;

class FPTFLine
{
    public string $type;
    public string $id;
    public string $line;

    public function __construct(string $id, string $line)
    {
        $this->type = "line";
        $this->id = $id;
        $this->line = $line;
    }
}
