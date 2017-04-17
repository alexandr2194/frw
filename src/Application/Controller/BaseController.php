<?php

namespace Application\Controller;

use Application\Http\Request\Request;
use Application\Http\Response\Response;

abstract class BaseController
{
    /** @var \Twig_Environment */
    private $templateEngine;

    abstract public function action(Request $request): Response;

    final public function load(\Twig_Environment $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    final public function render(string $templatePath, array $parameters): Response
    {
        return new Response($this->templateEngine->render($templatePath, $parameters), Response::OK_HTTP_RESPONSE_CODE);
    }
}