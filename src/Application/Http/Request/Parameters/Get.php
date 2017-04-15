<?php
namespace Application\Http\Request\Parameters;

use Application\Exception\InternalApplicationException;

class Get
{
    /** @var array */
    private $get;

    public function __construct(array $get)
    {
        $this->get = $get;
    }

    public function get(string $key)
    {
        if (!$this->exist($key)) {
            throw new InternalApplicationException(sprintf("Get parameter with key '%s' not found.", $key));
        }

        return $this->get[$key];
    }

    private function exist(string $key): bool
    {
        return isset($this->get[$key]);
    }
}