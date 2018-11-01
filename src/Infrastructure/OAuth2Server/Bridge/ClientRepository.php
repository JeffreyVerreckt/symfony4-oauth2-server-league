<?php

namespace App\Infrastructure\oAuth2Server\Bridge;

use App\Domain\Repository\ClientRepositoryInterface as AppClientRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

final class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var AppClientRepositoryInterface
     */
    private $appClientRepository;

    /**
     * ClientRepository constructor.
     * @param AppClientRepositoryInterface $clientRepository
     */
    public function __construct(AppClientRepositoryInterface $appClientRepository)
    {
        $this->appClientRepository = $appClientRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientEntity(
        $clientIdentifier,
        $grantType = null,
        $clientSecret = null,
        $mustValidateSecret = true
    ): ?ClientEntityInterface {
        $appClient = $this->appClientRepository->findActive($clientIdentifier);
        if ($appClient === null) {
            return null;
        }

        if ($mustValidateSecret && !hash_equals($appClient->getSecret(), (string)$clientSecret)) {
            return null;
        }

        $oauthClient = new Client($clientIdentifier, $appClient->getName(), $appClient->getRedirect());
        return $oauthClient;
    }
}