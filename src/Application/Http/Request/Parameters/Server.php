<?php

namespace Application\Http\Request\Parameters;

use Application\Exception\InternalApplicationException;

class Server
{
    /** @var array */
    private $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function get(string $key)
    {
        if (!$this->exist($key)) {
            throw new InternalApplicationException(sprintf("Server parameter with key '%s' not found.", $key));
        }

        return $this->server[$key];
    }

    private function exist(string $key): bool
    {
        return isset($this->server[$key]);
    }
}