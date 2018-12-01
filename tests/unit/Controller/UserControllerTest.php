<?php
namespace App\Controller;

use App\Model\User;
use App\Model\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tests for UserController class.
 */
class UserControllerTest extends TestCase
{
    /**
     * @var UserController
     */
    protected $sut;

    /**
     * @var UserRepositoryInterface|MockObject
     */
    protected $userRepository;

    public function setUp()
    {
        $this->userRepository = $this->getMockBuilder(UserRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['setLimit', 'setOffset', 'findAll', 'findByName', 'findOneById'])
            ->getMock();
        $this->userRepository->method('setLimit')->willReturn($this->userRepository);
        $this->userRepository->method('setOffset')->willReturn($this->userRepository);

        $this->sut = new UserController($this->userRepository);
    }

    ////////////////////////////////////////////////////////////////////////////
    /// User List

    public function testUserList_WithNoParameter_ReturnsAllUsers()
    {
        $user1 = (new User())->setUserId('user1');
        $user2 = (new User())->setUserId('user2');

        $expected = [$user1->getListArray(), $user2->getListArray()];

        $this->userRepository->method('findAll')->willReturn([$user1, $user2]);

        /** @var Request|MockObject $request */
        $request = $this->getRequestMock();
        $actual = $this->sut->userList($request);

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    public function testUserList_WithNameParameterAndExistingUser_ReturnsSearchResult()
    {
        $user = (new User())->setUserId('user1');
        $userName = 'fosterabigail';

        $expected = [$user->getListArray()];

        $this->userRepository->method('findByName')->with($userName)->willReturn([$user]);

        /** @var Request|MockObject $request */
        $request = $this->getRequestMock(['name' => $userName]);
        $actual = $this->sut->userList($request);

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    public function testUserList_WithNoUsers_ReturnsEmptyJson()
    {
        $expected = [];

        // No parameters, so we try to find all users.
        /** @var Request|MockObject $request */
        $request = $this->getRequestMock();
        $actual = $this->sut->userList($request);

        // No users
        $this->userRepository->method('findAll')->willReturn([]);

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    ////////////////////////////////////////////////////////////////////////////
    /// User Details

    public function testUserDetails_WithExistingId_ReturnsJson()
    {
        $user = (new User())->setUserId('user1');
        $expected = $user->getDetailsArray();
        $userName = 'fosterabigail';

        // User found
        $this->userRepository->method('findOneById')->with($userName)->willReturn($user);

        $actual = $this->sut->userDetails($userName);

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    public function testUserDetails_WithNotExistingId_ReturnsHttp404()
    {
        $expected = '"User not found!"';

        // User not found
        $this->userRepository->method('findOneById')->willReturn(null);

        $actual = $this->sut->userDetails('');

        $this->assertEquals($expected, $actual->getContent());
        $this->assertEquals(404, $actual->getStatusCode());
    }

    /**
     * Creates a request with the given parameters.
     *
     * @param array $parameters configured parameters for limit, offset and name
     *
     * @return MockObject
     */
    protected function getRequestMock(array $parameters = []): MockObject
    {
        // By default, no parameter is given => all return null.
        $parameters = array_merge(['limit' => 0, 'offset' => 0, 'name' => ''], $parameters);

        // Mapped values for the get method.
        $map = [
            ['limit', 0, $parameters['limit']],
            ['offset', 0, $parameters['offset']],
            ['name', '', $parameters['name']],
        ];

        $request = $this->createMock(Request::class);
        $request->method('get')->willReturnMap($map);

        return $request;
    }
}
