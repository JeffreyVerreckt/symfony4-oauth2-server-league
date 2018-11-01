<?php

namespace App\Domain\Repository;

use App\Domain\Model\Client;

interface ClientRepositoryInterface
{
    public function findActive(string $clientId): ?Client;
}