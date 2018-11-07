<?php

namespace App\Domain\Repository;

use App\Domain\Model\RefreshToken;

interface RefreshTokenRepositoryInterface
{
    public function find(string $refreshTokenId): ?RefreshToken;

    public function save(RefreshToken $refreshToken): void;
}