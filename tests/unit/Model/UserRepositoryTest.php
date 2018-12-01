<?php
namespace App\Model;

use PHPUnit\Framework\TestCase;

/**
 * Tests for UserRepository class.
 */
class UserRepositoryTest extends TestCase
{
    const TEST_USERS = [
        'fosterabigail' => [
            'login' => 'fosterabigail',
            'password' => 'P7ghvUQJNr6myOEP',
            'title' => 'mrs',
            'lastname' => 'foster',
            'firstname' => 'abigail',
            'gender' => 'female',
            'email' => 'abigail.foster60@example.com',
            'picture' => 'https://api.randomuser.me/0.2/portraits/women/10.jpg',
            'address' => '1851 saddle dr anna 69319',
        ],
        'grahamallison' => [
            'login' => 'grahamallison',
            'password' => 'LT9FaWRD7J7gS9Dw',
            'title' => 'ms',
            'lastname' => 'graham',
            'firstname' => 'allison',
            'gender' => 'female',
            'email' => 'allison.graham70@example.com',
            'picture' => 'https://api.randomuser.me/0.2/portraits/women/35.jpg',
            'address' => '6697 rolling green rd colorado springs 56306',
        ]
    ];

    /**
     * @var UserRepository
     */
    protected $sut;

    public function setUp()
    {
        // @todo: provided user data should be User objects, not array of arrays.
        $this->sut = new UserRepository(self::TEST_USERS);
    }

    /**
     * @dataProvider limitsAndOffsetsToTest
     *
     * @param int   $limit
     * @param int   $offset
     * @param array $expected
     */
    public function testFindAll_WithLimitAndOffset(int $limit, int $offset, array $expected)
    {
        $this->sut
            ->setLimit($limit)
            ->setOffset($offset);

        $this->assertEquals($expected, $this->sut->findAll());
    }

    public function limitsAndOffsetsToTest()
    {
        return [
            [0, 0, self::TEST_USERS],
            [1, 0, ['fosterabigail' => self::TEST_USERS['fosterabigail']]],
            [1, 1, ['grahamallison' => self::TEST_USERS['grahamallison']]],
            [2, 1, ['grahamallison' => self::TEST_USERS['grahamallison']]],
        ];
    }

    public function testFindOneById_WithExistingUser_ReturnsUser()
    {
        $this->assertEquals(new User(self::TEST_USERS['fosterabigail']), $this->sut->findOneById('fosterabigail'));
    }

    public function testFindOneById_WithNotExistingUser_ReturnsNull()
    {
        $this->assertEquals(null, $this->sut->findOneById('not existing id'));
    }
}