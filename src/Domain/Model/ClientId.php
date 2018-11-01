<?php
namespace App\Domain\Model;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ClientId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public function __construct(UuidInterface $uuid)
    {
        Assertion::uuid($uuid);
        $this->uuid = $uuid;
    }

    public static function fromString(string $clientId): ClientId
    {
        return new self(Uuid::fromString($clientId));
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals($other): bool
    {
        return $other instanceof self && $this->uuid->equals($other->uuid);
    }
}