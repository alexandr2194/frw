<?php

namespace Application\Http\Request\Parameters;

class Query
{
    /** @var string */
    private $queryString;

    public function __construct(string $queryString)
    {
        $this->queryString = $queryString;
    }

    public function all(): string
    {
        return $this->queryString;
    }
}