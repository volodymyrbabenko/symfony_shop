<?php

declare(strict_types=1);

namespace App\Doctrine;

use App\ValueObject\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class UserIdType extends IdValueObjectType
{
    protected const TYPE = 'user_id';

    /** @param ?string $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if ($value === null) {
            return null;
        }

        return UserId::fromString($value);
    }
}