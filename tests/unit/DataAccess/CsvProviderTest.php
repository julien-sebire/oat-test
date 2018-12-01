<?php
namespace App\DataAccess;

use PHPUnit\Framework\TestCase;

/**
 * Tests for CsvProvider class.
 */
class CsvProviderTest extends TestCase
{
    const SOURCE_FILE = __DIR__ . '/../_resources/testtakers.csv';

    const FIRST_USER = [
        'login' => 'fosterabigail',
        'password' => 'P7ghvUQJNr6myOEP',
        'title' => 'mrs',
        'lastname' => 'foster',
        'firstname' => 'abigail',
        'gender' => 'female',
        'email' => 'abigail.foster60@example.com',
        'picture' => 'https://api.randomuser.me/0.2/portraits/women/10.jpg',
        'address' => '1851 saddle dr anna 69319',
    ];

    /**
     * @var JsonProvider
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new CsvProvider();
        $this->sut->setSourceFile(self::SOURCE_FILE);
    }

    public function testLoadUsersFromFile()
    {
        $actual = $this->sut->loadUsersFromFile();

        $this->assertEquals(100, count($actual));
        $this->assertEquals(self::FIRST_USER, $actual[0]);
    }
}
