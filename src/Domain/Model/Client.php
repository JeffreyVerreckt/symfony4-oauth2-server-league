<?php

namespace App\Domain\Model;

use Ramsey\Uuid\Uuid;

class Client
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $redirect;

    /**
     * @var bool
     */
    private $active;

    /**
     * Client constructor.
     * @param ClientId $clientId
     * @param string $name
     */
    private function __construct(ClientId $clientId, string $name)
    {
        $this->id = $clientId->toString();
        $this->name = $name;
    }

    public static function create(string $name): Client
    {
        $clientId = ClientId::fromString(Uuid::uuid4()->toString());
        return new self($clientId, $name);
    }

    public function getId(): UserId
    {
        return UserId::fromString($this->id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getRedirect(): string
    {
        return $this->redirect;
    }

    /**
     * @param string $redirect
     */
    public function setRedirect(string $redirect): void
    {
        $this->redirect = $redirect;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}