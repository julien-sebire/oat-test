<?php
namespace App\DataAccess;

use App\Model\User;

/**
 * Retrieves data from Json file
 */
abstract class FileProvider implements UserProviderInterface
{
    /**
     * @var string
     */
    protected $sourceFile = '';

    /**
     * @return string
     */
    public function getSourceFile(): string
    {
        return $this->sourceFile;
    }

    /**
     * @param string $sourceFile
     *
     * @return self
     * @throws \RuntimeException when the source file does not exist or can not be read.
     */
    public function setSourceFile(string $sourceFile): self
    {
        // Checks that the source file exists and is readable.
        if (!is_readable($sourceFile)) {
            throw new \RuntimeException('Database file is not found or can not be read.');
        }

        $this->sourceFile = $sourceFile;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load(): array
    {
        // Load raw user data from source file.
        $arrayUsers = $this->loadUsersFromFile();

        // Converts each user array to a User object
        return array_map(
            function (array $user) {
                return new User($user);
            },
            $arrayUsers
        );
    }

    /**
     * Reads users from file as array of arrays.
     *
     * @return array
     */
    abstract public function loadUsersFromFile();
}