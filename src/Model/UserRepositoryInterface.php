<?php
namespace App\Model;

/**
 * Retrieves user(s) from database.
 */
interface UserRepositoryInterface
{
    /**
     * Sets a limit to the number of results returned.
     *
     * @param int $limit max number of results returned (0 means no limit).
     *
     * @return self
     */
    public function setLimit(int $limit): UserRepositoryInterface;

    /**
     * Sets an offset to the results array.
     *
     * @param int $offset index of the first result returned (beginning at 0).
     *
     * @return self
     */
    public function setOffset(int $offset): UserRepositoryInterface;

    /**
     * Returns all users
     *
     * @return array|User[]
     */
    public function findAll(): array;

    /**
     * Returns all users responding to a name or a login (partially)
     *
     * @param string $name name to be searched.
     *
     * @return array|User[]
     */
    public function findByName(string $name): array;

    /**
     * Finds an object given an id.
     * This method is not affected by limit and offset properties.
     *
     * @param string $id id of the object to find.
     *
     * @return User|null
     */
    public function findOneById(string $id): ?User;
}