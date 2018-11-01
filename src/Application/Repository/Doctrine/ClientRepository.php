<?php
namespace App\Application\Repository\Doctrine;

use App\Domain\Model\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class ClientRepository implements ClientRepositoryInterface
{
    private const ENTITY = Client::class;

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

    /**
     * @param string $clientId
     * @return Client|null
     */
    public function findActive(string $clientId): ?Client
    {
        return $this->objectRepository->findOneBy(['id' => $clientId, 'active' => true]);
    }
}