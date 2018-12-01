<?php
namespace App\Model;

use App\DataAccess\UserProviderInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for UserRepository class.
 */
class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    protected $sut;

    /**
     * @var array|User[]
     */
    protected $users;

    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    public function setUp()
    {
        // Provides User objects to the repository.
        $this->userProvider = $this->createConfiguredMock(
            UserProviderInterface::class,
            ['load' => $this->convertUsersData()]
        );

        $this->sut = new UserRepository($this->userProvider);
    }

    /**
     * @dataProvider limitsAndOffsetsToTest
     *
     * @param int          $limit
     * @param int          $offset
     * @param array|User[] $expected
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
        // Can not use a variable that has been set in the setUp method, as this data provider is called before setUp for each test.
        $users = $this->convertUsersData();

        return [
            'no limit returns all' => [0, 0, $users],
            'lirst page' => [1, 0, [$users[0]]],
            'last page' => [1, 1, [$users[1]]],
            'out of bound returns inbound array' => [2, 1, [$users[1]]],
        ];
    }

    public function testFindOneById_WithExistingUser_ReturnsUser()
    {
        $users = $this->convertUsersData();

        $this->assertEquals($users[0], $this->sut->findOneById('fosterabigail'));
    }

    public function testFindOneById_WithNotExistingUser_ReturnsNull()
    {
        $this->assertEquals(null, $this->sut->findOneById('not existing id'));
    }

    /**
     * Provides array of User objects instead of array of arrays.
     *
     * @return array|User[]
     */
    protected function convertUsersData()
    {
        $rawData = [
            [
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
            [
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

        return array_map(
            function (array $user) {
                return new User($user);
            },
            $rawData
        );
    }
}
