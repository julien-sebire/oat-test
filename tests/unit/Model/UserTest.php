<?php
namespace App\Model;

use PHPUnit\Framework\TestCase;

/**
 * Tests for User class.
 */
class UserTest extends TestCase
{
    const TEST_USER = [
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
     * @var User
     */
    protected $sut;

    public function testConstructorAndAccessors()
    {
        $this->sut = new User(self::TEST_USER);

        $fields = [
            'login' => 'getUserId',
            'password' => 'getPassword',
            'title' => 'getTitle',
            'lastname' => 'getLastname',
            'firstname' => 'getFirstname',
            'gender' => 'getGender',
            'email' => 'getEmail',
            'picture' => 'getPicture',
            'address' => 'getAddress',
        ];

        foreach ($fields as $field => $getter) {
            $this->assertEquals(self::TEST_USER[$field], $this->sut->$getter());
        }
    }

    public function testConstructor_WithUnknownField_ThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->sut = new User(['unknown field name' => 'whatever']);
    }

    public function testToArray()
    {
        $this->sut = new User(self::TEST_USER);

        $expected = [
            'userId' => 'fosterabigail',
            'password' => 'P7ghvUQJNr6myOEP',
            'title' => 'mrs',
            'lastname' => 'foster',
            'firstname' => 'abigail',
            'gender' => 'female',
            'email' => 'abigail.foster60@example.com',
            'picture' => 'https://api.randomuser.me/0.2/portraits/women/10.jpg',
            'address' => '1851 saddle dr anna 69319',
        ];

        $this->assertEquals($expected, $this->sut->toArray());
    }
}