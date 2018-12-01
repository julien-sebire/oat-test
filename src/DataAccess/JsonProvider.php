<?php
namespace App\DataAccess;

use App\Model\User;

/**
 * Retrieves data from Json file
 */
class JsonProvider implements UserProviderInterface
{
    /**
     * @var string
     */
    private $sourceFile = '';

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
     * @return JsonProvider
     */
    public function setSourceFile(string $sourceFile): self
    {
        $this->sourceFile = $sourceFile;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load(): array
    {
        // Load raw user data from source file.
        $arrayUsers = json_decode(file_get_contents($this->sourceFile), true);

        // Converts each user array to a User object
        return array_map(
            function (array $user) {
                return new User($user);
            },
            $arrayUsers
        );
    }
}