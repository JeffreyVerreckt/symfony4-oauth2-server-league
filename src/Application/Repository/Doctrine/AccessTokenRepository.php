<?php

namespace App\Application\Repository\Doctrine;

use App\Domain\Model\AccessToken;
use App\Domain\Repository\AccessTokenRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    private const ENTITY = AccessToken::class;

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

    public function find(string $accessTokenId): ?AccessToken
    {
       return $this->entityManager->find(self::ENTITY, $accessTokenId);
    }

    public function save(AccessToken $accessToken): void
    {
        $this->entityManager->persist($accessToken);
        $this->entityManager->flush();
    }
}