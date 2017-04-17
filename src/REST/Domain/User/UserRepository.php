<?php

namespace REST\Domain\User;

use REST\Domain\Storage\Storage;
use REST\Infrastructure\Storage\MySqlStorage;

class UserRepository
{
    const USERS_TABLE = 'users';
    const ID_FIELD = 'id';
    const NAME_FIELD = 'name';
    const FIRST_NAME_FIELD = 'first_name';


    /** @var MySqlStorage */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function add(User $user)
    {
        echo 1;
        $query = $this->storage->queryBuilder()
            ->insertInto(self::USERS_TABLE)
            ->insertValue(self::ID_FIELD, $user->getId())
            ->insertValue(self::NAME_FIELD, $user->getName())
            ->insertValue(self::FIRST_NAME_FIELD, $user->getFirstName())
            ->solve();
        $this->storage->exec($query);
    }

    public function delete(User $user)
    {
        $query = $this->storage->queryBuilder()
            ->deleteFrom(self::USERS_TABLE)
            ->where(sprintf('id=%s', $user->getId()))
            ->solve();
        $this->storage->exec($query);
    }

    public function update(User $user)
    {
        $query = $this->storage->queryBuilder()
            ->update(self::USERS_TABLE)
            ->updateSet(self::NAME_FIELD, $user->getName())
            ->updateSet(self::FIRST_NAME_FIELD, $user->getFirstName())
            ->solve();
        $this->storage->exec($query);
    }

    /**
     * @param string $condition
     * @return User[]
     */
    public function find(array $conditions): array
    {
        $query = $this->storage->queryBuilder()
            ->selectFrom(self::USERS_TABLE)
            ->where($conditions[0]);

        array_pop($conditions);
        foreach ($conditions as $condition) {
            $query->andWhere($condition);
        }
        $result = $this->storage->exec($query->solve());
        foreach ($result as $value) {
            $users[] = new User($value[self::ID_FIELD], $value[self::NAME_FIELD], $value[self::FIRST_NAME_FIELD]);
        }

        return $users ?? [];
    }
}