<?php

namespace Application\Http\Request;

use Application\Http\Request\Parameters\Files;
use Application\Http\Request\Parameters\Get;
use Application\Http\Request\Parameters\Headers;
use Application\Http\Request\Parameters\Post;
use Application\Http\Request\Parameters\Query;
use Application\Http\Request\Parameters\Server;
use Application\Http\Request\Parameters\Session;

class Request
{

    /** @var Headers */
    private $headers;
    /** @var Server */
    private $server;
    /** @var Session */
    private $sessions;
    /** @var Post */
    private $post;
    /** @var Get */
    private $get;
    /** @var Files */
    private $files;

    public function __construct(Headers $headers, Server $server, Session $sessions, Post $post, Get $get, Files $files)
    {
        $this->headers = $headers;
        $this->server = $server;
        $this->sessions = $sessions;
        $this->post = $post;
        $this->get = $get;
        $this->files = $files;
    }

    public function headers(): Headers
    {
        return $this->headers;
    }

    public function server(): Server
    {
        return $this->server;
    }

    public function sessions(): Session
    {
        return $this->sessions;
    }

    public function post(): Post
    {
        return $this->post;
    }

    public function get(): Get
    {
        return $this->get;
    }

    public function files(): Files
    {
        return $this->files;
    }

    public function query(): Query
    {
        return new Query($this->server->get('REQUEST_URI'));
    }
}