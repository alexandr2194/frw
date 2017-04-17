<?php

namespace Application\Router;

class Route
{
    /** @var string */
    private $path;
    /** @var string */
    private $controllerServiceName;

    public function __construct(string $path, string $controllerClassName)
    {
        $this->path = $path;
        $this->controllerServiceName = $controllerClassName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getControllerServiceName(): string
    {
        return $this->controllerServiceName;
    }
}