<?php

namespace REST\Domain\Storage;

interface Storage
{
    public function connect(array $options);

    public function exec(Query $query);
}