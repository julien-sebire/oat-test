<?php

namespace App\Controller;

use App\Model\User;
use App\Model\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Provides access to test takers list and details.
 */
class UserController extends AbstractController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
        $limit = $request->get('limit', 0);
        $offset = $request->get('offset', 0);
        $name = $request->get('name', '');

        // Sets query parameters, to avoid parameters multiplication in find* methods.
        $this->userRepository
            ->setLimit($limit)
            ->setOffset($offset);

        // Only two methods are necessary : either a name search or a full set.
        $users = ($name !== ''
            ? $this->userRepository->findByName($name)
            : $this->userRepository->findAll()
        );

        if (count($users) === 0) {
            return new JsonResponse([]);
        }

        return new JsonResponse(
            array_map(
                function (User $user) {
                    return $user->toArray();
                },
                $users
            )
        );
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
        try {
            $user = $this->userRepository->findOneById($id);
        } catch(\LogicException $exception) {
            return new JsonResponse($exception->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($user === null) {
            return new JsonResponse('User not found!', JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user->toArray());
    }
}
