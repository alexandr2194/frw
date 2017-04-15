<?php

namespace App\UserInterface\Controller;

use Application\Http\Request\Request;
use Application\Http\Response\Response;

class IndexController
{
    public function indexAction(Request $request)
    {
        return new Response();
    }
}