<?php

namespace App\Controller;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\ParameterBag;
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

    public function testUserList_WithNoData_ReturnsJson()
    {
        $expected = [
            [
                'userId' => 'fosterabigail',
                'password' => 'P7ghvUQJNr6myOEP',
                'title' => 'mrs',
                'lastname' => 'foster',
                'firstname' => 'abigail',
                'gender' => 'female',
                'email' => 'abigail.foster60@example.com',
                'picture' => 'https://api.randomuser.me/0.2/portraits/women/10.jpg',
                'address' => '1851 saddle dr anna 69319',
            ]
        ];

        /** @var Request|MockObject $request */
        $request = $this->createConfiguredMock(Request::class, ['get' => 'fosterabigail']);
        $actual = $this->sut->userList($request);

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    public function testUserList_WithNoData_ReturnsHttp404()
    {
        $expected = '"No user found!"';

        /** @var Request|MockObject $request */
        $request = $this->createConfiguredMock(Request::class, []);
        $actual = $this->sut->userList($request);

        $this->assertEquals($expected, $actual->getContent());
        $this->assertEquals(404, $actual->getStatusCode());
    }

    public function testUserDetails_WithExistingId_ReturnsJson()
    {
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
        $actual = $this->sut->userDetails('fostedrabigail');

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    public function testUserDetails_WithNotExistingId_ReturnsHttp404()
    {
        $expected = '"User not found!"';
        $actual = $this->sut->userDetails('');

        $this->assertEquals($expected, $actual->getContent());
        $this->assertEquals(404, $actual->getStatusCode());
    }
}
