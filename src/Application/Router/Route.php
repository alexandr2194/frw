<?php

namespace Application\Router;

class Route
{
    /** @var string */
    private $path;
    /** @var string */
    private $controllerClassName;

    public function __construct(string $path, string $controllerClassName)
    {
        $this->path = $path;
        $this->controllerClassName = $controllerClassName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getControllerClassName(): string
    {
        return $this->controllerClassName;
    }
}