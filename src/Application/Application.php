<?php

namespace Application;

use Application\Config\Config;
use Application\Controller\BaseController;
use Application\Exception\BadRequestException;
use Application\Exception\InternalApplicationException;
use Application\Exception\RouteNotFoundException;
use Application\Http\Request\Request;
use Application\Http\Response\Response;
use Application\Router\Route;
use Application\Router\Router;
use Twig_Environment;

class Application
{
    /** @var Config */
    private $config;
    /** @var Router */
    private $router;
    /** @var Twig_Environment */
    private $templateEngine;

    public function __construct(Config $config, Router $router, Twig_Environment $templateEngine)
    {
        $this->config = $config;
        $this->router = $router;
        $this->templateEngine = $templateEngine;
    }

    public function launch(Request $request): Response
    {
        try {
            $route = $this->router->getByPath($request->query()->all());
            $controller = $this->getController($route);
            return $controller->action($request);
        } catch (BadRequestException $badRequestException) {
            return new Response($badRequestException->getMessage(), Response::BAD_REQUEST_HTTP_RESPONSE_CODE);
        } catch (RouteNotFoundException $routeNotFoundException) {
            return new Response($routeNotFoundException->getMessage(), Response::NOT_FOUND_RESPONSE_CODE);
        } catch (InternalApplicationException $internalApplicationException) {
            return new Response($internalApplicationException->getMessage(), Response::INTERNAL_ERROR_HTTP_RESPONSE_CODE);
        }
    }

    private function getController(Route $route): BaseController
    {
        $controllerClassName = "App\\UserInterface\\Controller\\" . $route->getControllerClassName();
        return new $controllerClassName($this->templateEngine);
    }
}