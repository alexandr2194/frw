<?php

namespace App\UserInterface\Controller;

use Application\Controller\BaseController;
use Application\Http\Request\Request;
use Application\Http\Response\Response;

class IndexController extends BaseController
{
    public function action(Request $request): Response
    {
        return $this->render(
            'base.html.twig',
            [
                'content' => 1
            ]
        );
    }
}