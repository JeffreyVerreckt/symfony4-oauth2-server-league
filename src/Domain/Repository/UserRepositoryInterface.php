<?php
namespace App\Domain\Repository;

use App\Domain\Model\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function find(UuidInterface $id): ?User;

    public function findOneByEmail(string $username): ?User;

    public function save(User $user): void;

    public function remove(User $user): void;
}