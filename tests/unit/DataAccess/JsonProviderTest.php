<?php
namespace App\DataAccess;

use App\Model\User;
use PHPUnit\Framework\TestCase;

/**
 * Tests for JsonAccessor class.
 */
class JsonProviderTest extends TestCase
{
    const SOURCE_FILE = __DIR__ . '/../_resources/testtakers.json';

    /**
     * @var JsonProvider
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new JsonProvider();
    }

    public function testAccessors()
    {
        $sourceFile = self::SOURCE_FILE;
        $this->assertEquals($this->sut, $this->sut->setSourceFile($sourceFile));
        $this->assertEquals($sourceFile, $this->sut->getSourceFile());
    }

    public function testLoad()
    {
        $this->sut->setSourceFile(self::SOURCE_FILE);

        $actual = $this->sut->load();

        $this->assertEquals(100, count($actual));

        $ExpectedFirstUser = new User([
            'login' => 'fosterabigail',
            'password' => 'P7ghvUQJNr6myOEP',
            'title' => 'mrs',
            'lastname' => 'foster',
            'firstname' => 'abigail',
            'gender' => 'female',
            'email' => 'abigail.foster60@example.com',
            'picture' => 'https://api.randomuser.me/0.2/portraits/women/10.jpg',
            'address' => '1851 saddle dr anna 69319',
        ]);
        $this->assertEquals($ExpectedFirstUser, $actual[0]);
    }
}
