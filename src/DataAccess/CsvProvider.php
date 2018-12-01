<?php
namespace App\DataAccess;

/**
 * Retrieves data from Csv file
 */
class CsvProvider extends FileProvider
{
    /**
     * {@inheritdoc}
     *
     * Csv parsing based on https://secure.php.net/manual/en/function.str-getcsv.php#117692
     */
    public function loadUsersFromFile(): array
    {
        // Reads each line of csv file into an indexed array.
        $users = array_map('str_getcsv', file($this->sourceFile));

        // Gets field names and remove first line.
        $fieldNames = array_shift($users);

        // Assigns field names to each line
        array_walk(
            $users,
            function (&$a) use ($fieldNames) {
                $a = array_combine($fieldNames, $a);
            }
        );

        return $users;
    }
}