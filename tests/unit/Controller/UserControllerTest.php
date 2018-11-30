<?php
namespace App\Controller;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tests for UserControllerTest class.
 */
class UserControllerTest extends TestCase
{
    /**
     * @var UserController
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new UserController();
    }

    public function testUserList_WithNoData_ReturnsEmptyJson()
    {
        /** @var Request|MockObject $request */
        $request = $this->createConfiguredMock(Request::class, []);

        $expected = [];
        $actual = $this->sut->userList($request);

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    public function testUserDetails_WithoutId_ReturnsEmptyJson()
    {
        $expected = [];
        $actual = $this->sut->userDetails('');

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }
}
