<?php

namespace Application\Http\Request\Parameters;

use Application\Exception\InternalApplicationException;

class Headers
{
    /**
     * @var array
     */
    private $headers;

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function get(string $key)
    {
        if (!$this->exist($key)) {
            throw new InternalApplicationException(sprintf("Header with key '%s' not found.", $key));
        }

        return $this->headers[$key];

    }

    private function exist(string $key): bool
    {
        return isset($this->headers[$key]);
    }
}