<?php

namespace App\Application\Repository\Doctrine;

use App\Domain\Model\RefreshToken;
use App\Domain\Repository\AccessTokenRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class RefreshTokenRepository implements AccessTokenRepositoryInterface
{
    private const ENTITY = RefreshToken::class;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    /**
     * UserRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(self::ENTITY);
    }

    public function find(string $accessTokenId): ?RefreshToken
    {
       return $this->entityManager->find(self::ENTITY, $accessTokenId);
    }

    public function save(RefreshToken $accessToken): void
    {
        $this->entityManager->persist($accessToken);
        $this->entityManager->flush();
    }
}