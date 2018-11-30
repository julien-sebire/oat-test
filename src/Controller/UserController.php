<?php
namespace App\Controller;

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
        $users = [];

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
        $user = [];

        return new JsonResponse($user);
    }
}
