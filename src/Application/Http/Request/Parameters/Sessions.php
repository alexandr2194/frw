<?php

namespace Application\Http\Request\Parameters;

use Application\Exception\InternalApplicationException;

class Sessions
{
    /**
     * @var array
     */
    private $sessions;

    public function __construct(array $sessions)
    {
        $this->sessions = $sessions;
    }

    public function get(string $key)
    {
        if (!$this->exist($key)) {
            throw new InternalApplicationException(sprintf("Sessions parameter with key '%s' not found.", $key));
        }

        return $this->sessions[$key];
    }

    private function exist(string $key): bool
    {
        return isset($this->sessions[$key]);
    }
}