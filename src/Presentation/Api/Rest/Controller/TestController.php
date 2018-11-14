<?php
namespace App\Presentation\Api\Rest\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestController
 * @package App\Presentation\Api\Rest\Controller
 */
final class TestController implements TokenAuthenticatedController
{
    /**
     * @Route("test", name="api_test", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getTest(Request $request): Response
    {
        $id = $request->get('oauth_user_id');
        return new JsonResponse($id, Response::HTTP_OK);
    }
}