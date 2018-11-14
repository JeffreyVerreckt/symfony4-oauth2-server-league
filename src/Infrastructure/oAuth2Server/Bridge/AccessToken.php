<?php
namespace App\Infrastructure\oAuth2Server\Bridge;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

final class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait, EntityTrait, TokenEntityTrait;

    /**
     * AccessToken constructor.
     * @param string $userIdentifier
     * @param array $scopes
     */
    public function __construct(string $userIdentifier, array $scopes = [])
    {
        $this->setUserIdentifier($userIdentifier);
        foreach ($scopes as $scope) {
            $this->addScope($scope);
        }
    }
}