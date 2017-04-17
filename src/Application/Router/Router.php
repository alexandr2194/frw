<?php

namespace Application\Router;

use Application\Exception\RouteNotFoundException;

class Router
{
    const CONTROLLER_KEY = 'controller';
    const PATH_KEY = 'path';

    /** @var string */
    private $routes;

    public function __construct(string $routerFilePath)
    {
        $this->routes = $this->parseJsonRoutes($routerFilePath);
    }

    private function parseJsonRoutes(string $routerFilePath): array
    {
        $jsonRoutesContent = file_get_contents($routerFilePath);

        if (!$jsonRoutesContent) {
            throw new RouteNotFoundException("Error in process parsing config");
        }
        $routes = json_decode($jsonRoutesContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(json_last_error_msg());
        }

        return $routes;
    }

    public function getByPath(string $path): Route
    {
        foreach ($this->routes as $route) {
            $pattern = str_replace('/', '\/', $route[self::PATH_KEY]);
            if (preg_match('/\*/', $pattern)) {
                $pattern = str_replace('*', '[a-zA-Z0-9-_]*', $pattern);
            }
            $pattern = '/^' . $pattern . '$/';
            if (preg_match($pattern, $path)) {
                return new Route($path, $route[self::CONTROLLER_KEY]);
            }
        }
        throw new RouteNotFoundException(sprintf("Route Not found for path '%s'.", $path));
    }

}