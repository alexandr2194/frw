<?php
namespace Application\Http\Request\Parameters;

use Application\Exception\InternalApplicationException;

class Post
{
    /** @var array */
    private $post;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function get(string $key)
    {
        if (!$this->exist($key)) {
            throw new InternalApplicationException(sprintf("Post parameter with key '%s' not found.", $key));
        }

        return $this->post[$key];
    }

    private function exist(string $key): bool
    {
        return isset($this->post[$key]);
    }
}