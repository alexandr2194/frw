<?php
namespace Application\Http\Request\Parameters;

use Application\Exception\InternalApplicationException;

class Files
{
    /** @var array */
    private $files;

    public function __construct(array $files)
    {
        $this->files = $files;
    }

    public function get(string $key)
    {
        if (!$this->exist($key)) {
            throw new InternalApplicationException(sprintf("Get parameter with key '%s' not found.", $key));
        }

        return $this->files[$key];
    }

    private function exist(string $key): bool
    {
        return isset($this->files[$key]);
    }
}