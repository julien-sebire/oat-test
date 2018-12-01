<?php
namespace App\DataAccess;

use App\Model\User;
use PHPUnit\Framework\TestCase;

/**
 * Tests for FileProvider class.
 */
class FileProviderTest extends TestCase
{
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
     * @var FileProvider
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new TestableFileProvider();
    }

    public function testAccessors()
    {
        $sourceFile = __DIR__ . '/../_resources/testtakers.json';
        $this->assertEquals($this->sut, $this->sut->setSourceFile($sourceFile));
        $this->assertEquals($sourceFile, $this->sut->getSourceFile());
    }

    public function testSetSourceFile_WithNotExistingFile_ThrowsException()
    {
        $sourceFile = __DIR__ . '/not existing file';
        $this->expectException(\RuntimeException::class);
        $this->sut->setSourceFile($sourceFile);
    }

    public function testLoad()
    {
        $expectedUser = new User(self::FIRST_USER);

        $actual = $this->sut->load();

        $this->assertEquals([$expectedUser], $actual);
    }
}

/**
 * Used to allow calling abstract method.
 */
class TestableFileProvider extends FileProvider
{
    public function loadUsersFromFile(): array
    {
        // Returns an array with a single user array, since we want to test the array to User object conversion.
        return [FileProviderTest::FIRST_USER];
    }
}
