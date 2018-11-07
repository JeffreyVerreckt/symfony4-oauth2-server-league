<?php

namespace App\Domain\Repository;

use App\Domain\Model\AccessToken;

interface AccessTokenRepositoryInterface
{
    public function find(string $accessTokenId): ?AccessToken;

    public function save(AccessToken $accessToken): void;
}