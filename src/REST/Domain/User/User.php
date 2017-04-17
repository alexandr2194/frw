<?php

namespace REST\Domain\User;

class User
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $firstName;

    public function __construct(string $id, string $name, string $firstName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

}