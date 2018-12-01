<?php
namespace App\DataAccess;

/**
 * Retrieves data from Json file
 */
class JsonProvider extends FileProvider
{
    /**
     * {@inheritdoc}
     */
    public function loadUsersFromFile(): array
    {
        return json_decode(file_get_contents($this->sourceFile), true);
    }
}