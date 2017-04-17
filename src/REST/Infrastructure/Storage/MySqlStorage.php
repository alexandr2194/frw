<?php

namespace REST\Infrastructure\Storage;

use Application\Exception\InternalApplicationException;
use REST\Domain\Storage\Query;
use REST\Domain\Storage\QueryBuilder;
use REST\Domain\Storage\Storage;

class MySqlStorage implements Storage
{
    const DATABASE_KEY = 'database';
    const PASSWORD_KEY = 'password';
    const HOST_KEY = 'host';

    /** @var \mysqli */
    private $mysqlInstance;
    /** @var QueryBuilder */
    private $builder;

    public function __construct(QueryBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function connect(array $options)
    {
        $this->mysqlInstance = mysqli_connect(
            $options[self::HOST_KEY] ?? "",
            $options[self::PASSWORD_KEY] ?? "",
            $options[self::DATABASE_KEY] ?? ""
        );
    }

    public function exec(Query $query)
    {
        $queryResult = $this->mysqlInstance->query($query);
        if ($queryResult) {
            if (in_array($query->type(), [MySqlQuery::SELECT_QUERY_TYPE])) {
                return $queryResult->fetch_assoc();
            }
        }

        throw new InternalApplicationException(sprintf("Mysql query process has error in query: %s.", $query));
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->builder;
    }
}