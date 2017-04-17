<?php

namespace REST\Infrastructure\Storage;

use Application\Exception\BadQueryException;
use REST\Domain\Storage\Query;
use REST\Domain\Storage\QueryBuilder;

class MySqlQueryBuilder implements QueryBuilder
{
    const SELECT_TYPE = 'select';
    const UPDATE_TYPE = 'update';
    const INSERT_TYPE = 'insert';
    const DELETE_TYPE = 'delete';

    const TABLE_KEY = 'table';
    const TYPE_KEY = 'type';
    const VALUES_KEY = 'values';
    const SET_KEY = 'set';
    const FIELDS_KEY = 'fields';
    const ORDER_BY_KEY = 'order_by';
    const HAVING_KEY = 'having';
    const GROUP_BY_KEY = 'group_by';
    const AND_WHERE_KEY = 'and_where';
    const WHERE_KEY = 'where';

    /** @var $query string */
    private $query;

    /** @var $queryParts array */
    private $queryParts;

    public function selectFrom(string $table): QueryBuilder
    {
        $this->queryParts[self::TYPE_KEY] = self::SELECT_TYPE;
        $this->queryParts[self::TABLE_KEY] = $table;

        return $this;
    }

    public function where(string $condition): QueryBuilder
    {
        $this->queryParts[self::WHERE_KEY] = $condition;

        return $this;
    }

    public function andWhere(string $condition): QueryBuilder
    {
        $this->queryParts[self::AND_WHERE_KEY][] = $condition;

        return $this;
    }

    public function groupBy(string $field): QueryBuilder
    {
        $this->queryParts[self::GROUP_BY_KEY] = $field;

        return $this;
    }

    public function having(string $condition): QueryBuilder
    {
        $this->queryParts[self::HAVING_KEY] = $condition;

        return $this;
    }

    public function orderBy(string $field): QueryBuilder
    {
        $this->queryParts[self::ORDER_BY_KEY] = $field;

        return $this;
    }

    public function fields(array $fields): QueryBuilder
    {
        $this->queryParts[self::FIELDS_KEY] = $fields;

        return $this;
    }

    public function update(string $table): QueryBuilder
    {
        $this->queryParts[self::TYPE_KEY] = self::UPDATE_TYPE;
        $this->queryParts[self::TABLE_KEY] = $table;

        return $this;
    }

    public function updateSet(string $field, string $value): QueryBuilder
    {
        $this->queryParts[self::SET_KEY][$field] = $value;

        return $this;
    }

    public function insertInto(string $table): QueryBuilder
    {
        $this->queryParts[self::TYPE_KEY] = self::INSERT_TYPE;
        $this->queryParts[self::TABLE_KEY] = $table;

        return $this;
    }

    public function insertValue(string $field, string $value): QueryBuilder
    {
        $this->queryParts[self::VALUES_KEY][$field] = $value;

        return $this;
    }

    public function deleteFrom(string $table): QueryBuilder
    {
        $this->queryParts[self::TYPE_KEY] = self::DELETE_TYPE;
        $this->queryParts[self::TABLE_KEY] = $table;
    }

    public function solve(): Query
    {
        $queryType = $this->getQueryType();
        $table = $this->getTable();
        switch ($queryType) {
            case self::SELECT_TYPE:
                $this->query = $this->buildSelectQueryString($table);
                break;
            case self::UPDATE_TYPE:
                break;
            case self::INSERT_TYPE:
                break;
            case self::DELETE_TYPE:
                break;
        }

        $query = new MySqlQuery($queryType, $this->query);
        $this->clear();
        return $query;
    }

    private function getQueryType(): string
    {
        if (!isset($this->queryParts[self::TYPE_KEY])) {
            throw new BadQueryException("Query type not defined.");
        }
        return $this->queryParts[self::TYPE_KEY];
    }

    private function getTable(): string
    {
        if (!isset($this->queryParts[self::TABLE_KEY])) {
            throw new BadQueryException("Table not defined.");
        }
        return $this->queryParts[self::TABLE_KEY];
    }

    private function buildSelectQueryString(string $table): string
    {
        $fields = implode(", ", $this->queryParts[self::FIELDS_KEY] ?? ["*"]);
        $query = sprintf("SELECT %s FROM %s", $fields, $table);
        if (isset($this->queryParts[self::WHERE_KEY])) {
            $condition = $this->queryParts[self::WHERE_KEY];
            $query .= sprintf(' WHERE %s', $condition);
            if (isset($this->queryParts[self::AND_WHERE_KEY])) {
                $additionalConditions = $this->queryParts[self::AND_WHERE_KEY];
                foreach ($additionalConditions as $additionalCondition) {
                    $query .= sprintf(' AND WHERE %s', $additionalCondition);
                }
            }
        }

        if (isset($this->queryParts[self::GROUP_BY_KEY])) {
            $groupByField = $this->queryParts[self::GROUP_BY_KEY];
            $query .= sprintf(" GROUP BY %s", $groupByField);
            if (isset($this->queryParts[self::HAVING_KEY])) {
                $havingCondition = $this->queryParts[self::HAVING_KEY];
                $query .= sprintf(" HAVING %s", $havingCondition);
            }
        }

        if (isset($this->queryParts[self::ORDER_BY_KEY])) {
            $orderByField = $this->queryParts[self::ORDER_BY_KEY];
            $query .= sprintf(" ORDER BY %s", $orderByField);
        }

        return $query;
    }

    private function clear()
    {
        $this->query = "";
        $this->queryParts = [];
    }
}