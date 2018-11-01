<?php
namespace App\Infrastructure\oAuth2Server\Bridge;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

final class User implements UserEntityInterface
{
    use EntityTrait;

    /**
     * User constructor.
     * @param $identifier
     */
    public function __construct($identifier)
    {
        $this->setIdentifier($identifier);
    }
}