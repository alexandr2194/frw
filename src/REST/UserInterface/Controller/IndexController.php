<?php

namespace REST\UserInterface\Controller;

use Application\Controller\BaseController;
use Application\Http\Request\Request;
use Application\Http\Response\Response;
use REST\Domain\User\User;
use REST\Domain\User\UserRepository;

class IndexController extends BaseController
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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