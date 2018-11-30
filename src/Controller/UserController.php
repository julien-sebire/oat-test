<?php

namespace App\Controller;

use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class UserController
 * Provides access to test takers list and details
 */
class UserController extends AbstractController
{
    /**
     * Returns a list of users
     *
     * @param Request $request full request object used to retrieve optional parameters (limit, offset, name, ...)
     *
     * @return JsonResponse
     */
    public function userList(Request $request): JsonResponse
    {
        // Retrieves parameters from query string.

        $filter = $request->get('name');

        // Just a dummy test to ensure the client receives the good data format.
        if ($filter === 'fosterabigail') {
            $users = [
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
        } else {
            $users = [];
        }

        if (count($users) === 0) {
            return new JsonResponse('No user found!', JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($users);
    }

    /**
     * Returns details of a user.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function userDetails(string $id): JsonResponse
    {
        // Just a dummy test to ensure the client receives the good data format.
        if ($id === 'fosterabigail') {
            $user = [
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
        } else {
            $user = [];
        }

        if (count($user) === 0) {
            return new JsonResponse('User not found!', JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user);
    }
}
