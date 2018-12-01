<?php
namespace App\Model;

use App\Data\DataAccessorInterface;

/**
 * Retrieves user(s) from database.
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Max number of results returned (0 means no limit).
     *
     * @var int
     */
    protected $limit = 0;

    /**
     * Index of the first result returned (beginning at 0).
     *
     * @var int
     */
    protected $offset = 0;

    /**
     * Stores users.
     *
     * @var array|User[]
     */
    protected $users;

    public function __construct(array $users)
    {
        // @todo: ensure every element in array is a real User object.
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function setLimit(int $limit): UserRepositoryInterface
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOffset(int $offset): UserRepositoryInterface
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Returns all users
     *
     * @return array|User[]
     */
    public function findAll(): array
    {
        // Returns all users with pagination.
        return $this->paginate($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName(string $name): array
    {
        // Finds users responding to the given name.
        $users = array_filter($this->users, function (User $user) use ($name) {
            return $user->hasName($name);
        });

        // Returns selected users with pagination.
        return $this->paginate($users);
    }

    /**
     * Paginates results with limit and offset.
     *
     * @param array $users
     *
     * @return array
     */
    protected function paginate(array $users): array
    {
        // limit = 0 means no limit => return all.
        if ($this->limit === 0) {
            return $users;
        }

        // Slices users.
        return array_slice($users, $this->offset, $this->limit);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(string $id): ?User
    {
        // Finds user with the given id
        $users = array_filter($this->users, function (User $user) use ($id) {
            return $user->hasUserId($id);
        });

        switch (count($users)) {
            case 0 :
                // No user found.
                return null;
            case 1:
                // User found.
                return $users[0];
            default:
                // Corrupted database?
                throw new \LogicException('Found more than one users with the same id "' . $id . '"');
        }
    }
}