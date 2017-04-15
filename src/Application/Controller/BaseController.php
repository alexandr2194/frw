<?php

namespace Application\Controller;

use Application\Http\Request\Request;
use Application\Http\Response\Response;

class BaseController
{
    /** @var \Twig_Environment */
    private $templateEngine;

    public function __construct(\Twig_Environment $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function action(Request $request): Response
    {
    }

    public function render(string $templatePath, array $options): Response
    {
        return new Response($this->templateEngine->render($templatePath, $options), Response::OK_HTTP_RESPONSE_CODE);
    }


}