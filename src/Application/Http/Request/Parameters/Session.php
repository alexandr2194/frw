<?php

namespace Application\Http\Request\Parameters;

use Application\Exception\InternalApplicationException;

class Session
{
    /** @var array */
    private $session;

    public function __construct(array $session)
    {
        $this->session = $session;
    }

    public function get(string $key)
    {
        if (!$this->exist($key)) {
            throw new InternalApplicationException(sprintf("Session parameter with key '%s' not found.", $key));
        }

        return $this->session[$key];
    }

    private function exist(string $key): bool
    {
        return isset($this->session[$key]);
    }
}