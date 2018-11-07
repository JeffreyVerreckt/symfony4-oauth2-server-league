<?php
namespace App\Infrastructure\oAuth2Server\Bridge;

use App\Domain\Repository\AccessTokenRepositoryInterface as AppAccessTokenRepositoryInterface;
use App\Domain\Model\AccessToken as AppAccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

final class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @var AppAccessTokenRepositoryInterface
     */
    private $appAccessTokenRepository;

    /**
     * AccessTokenRepository constructor.
     * @param AppAccessTokenRepositoryInterface $appAccessTokenRepository
     */
    public function __construct(AppAccessTokenRepositoryInterface $appAccessTokenRepository)
    {
        $this->appAccessTokenRepository = $appAccessTokenRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null): AccessTokenEntityInterface
    {
        return new AccessToken($userIdentifier, $scopes);
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $appAccessToken = new AppAccessToken(
            $accessTokenEntity->getIdentifier(),
            $accessTokenEntity->getUserIdentifier(),
            $accessTokenEntity->getClient()->getIdentifier(),
            $this->scopesToArray($accessTokenEntity->getScopes()),
            false,
            new \DateTime(),
            new \DateTime(),
            $accessTokenEntity->getExpiryDateTime()
        );
        $this->appAccessTokenRepository->save($appAccessToken);
    }

    private function scopesToArray(array $scopes): array
    {
        return array_map(function ($scope) {
            return $scope->getIdentifier();
        }, $scopes);
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId): void
    {
        $appAccessToken = $this->appAccessTokenRepository->find($tokenId);
        if ($appAccessToken === null) {
            return;
        }
        $appAccessToken->revoke();
        $this->appAccessTokenRepository->save($appAccessToken);
    }

    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId): ?bool
    {
        $appAccessToken = $this->appAccessTokenRepository->find($tokenId);
        if ($appAccessToken === null) {
            return true;
        }
        return $appAccessToken->isRevoked();
    }
}