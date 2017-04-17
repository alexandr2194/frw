<?php

namespace REST\Domain\Storage;

interface QueryBuilder
{
    public function selectFrom(string $table): QueryBuilder;

    public function where(string $condition): QueryBuilder;

    public function andWhere(string $condition): QueryBuilder;

    public function groupBy(string $field): QueryBuilder;

    public function having(string $condition): QueryBuilder;

    public function orderBy(string $field): QueryBuilder;

    public function fields(array $fields): QueryBuilder;

    public function update(string $table): QueryBuilder;

    public function updateSet(string $field, string $value): QueryBuilder;

    public function insertInto(string $table): QueryBuilder;

    public function insertValue(string $field, string $value): QueryBuilder;

    public function deleteFrom(string $table): QueryBuilder;

    public function solve(): Query;
}