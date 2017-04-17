<?php

namespace REST\Infrastructure\Storage;

use REST\Domain\Storage\Query;

class MySqlQuery implements Query
{
    const SELECT_QUERY_TYPE = 'select';
    const UPDATE_QUERY_TYPE = 'update';
    const INSERT_QUERY_TYPE = 'insert';
    const DELETE_QUERY_TYPE = 'delete';

    /** @var string */
    private $query;
    /** @var string */
    private $queryType;

    public function __construct(string $queryType, string $query)
    {
        $this->query = $query;
        $this->queryType = $queryType;
    }

    public function type(): string
    {
        return $this->queryType;
    }

    public function __toString(): string
    {
        return $this->query;
    }
}