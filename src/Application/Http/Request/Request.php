<?php

namespace Application\Http\Request;

use Application\Http\Request\Parameters\Headers;
use Application\Http\Request\Parameters\Server;
use Application\Http\Request\Parameters\Sessions;

class Request
{

    /** @var Headers */
    private $headers;
    /** @var Server */
    private $server;
    /** @var Sessions */
    private $sessions;
    /** @var array */
    private $post;
    /** @var array */
    private $get;

    public function __construct(Headers $headers, Server $server, Sessions $sessions, array $post, array $get)
    {
        $this->headers = $headers;
        $this->server = $server;
        $this->sessions = $sessions;
        $this->post = $post;
        $this->get = $get;
    }

    public function headers(): Headers
    {
        return $this->headers;
    }

    public function server(): Server
    {
        return $this->server;
    }

    public function sessions(): Sessions
    {
        return $this->sessions;
    }

    public function post(): array
    {
        return $this->post;
    }

    public function get(): array
    {
        return $this->get;
    }
}