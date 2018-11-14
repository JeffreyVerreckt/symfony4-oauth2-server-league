<?php

namespace App\Presentation\Api\Rest\Controller;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\PasswordGrant;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Zend\Diactoros\Response as Psr7Response;

final class AuthController
{
    /**
     * @var AuthorizationServer
     */
    private $authorizationServer;

    /**
     * @var PasswordGrant
     */
    private $passwordGrant;

    /**
     * AuthController constructor.
     * @param AuthorizationServer $authorizationServer
     * @param PasswordGrant $passwordGrant
     */
    public function __construct(
        AuthorizationServer $authorizationServer,
        PasswordGrant $passwordGrant
    ) {
        $this->authorizationServer = $authorizationServer;
        $this->passwordGrant = $passwordGrant;
    }

    /**
     * @Route("accessToken", name="api_get_access_token", methods={"POST"})
     * @param ServerRequestInterface $request
     * @return null|Psr7Response
     * @throws \Exception
     */
    public function getAccessToken(ServerRequestInterface $request): ?Psr7Response
    {
        $this->passwordGrant->setRefreshTokenTTL(new \DateInterval('P1M'));

        return $this->withErrorHandling(function () use ($request) {
            $this->passwordGrant->setRefreshTokenTTL(new \DateInterval('P1M'));
            $this->authorizationServer->enableGrantType(
                $this->passwordGrant,
                new \DateInterval('PT1H')
            );
            return $this->authorizationServer->respondToAccessTokenRequest($request, new Psr7Response());
        });
    }

    private function withErrorHandling($callback): ?Psr7Response
    {
        try {
            return $callback();
        } catch (OAuthServerException $e) {
            return $this->convertResponse(
                $e->generateHttpResponse(new Psr7Response())
            );
        } catch (\Exception $e) {
            return new Psr7Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $e) {
            return new Psr7Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function convertResponse(Psr7Response $psrResponse): Psr7Response
    {
        return new Psr7Response(
            $psrResponse->getBody(),
            $psrResponse->getStatusCode(),
            $psrResponse->getHeaders()
        );
    }
}