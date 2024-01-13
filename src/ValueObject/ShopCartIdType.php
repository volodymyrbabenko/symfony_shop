<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\ValueObject\ShopCartId;
use DigitalCraftsman\Ids\Doctrine\IdType;
use DigitalCraftsman\Ids\ValueObject\Id;

final class ShopCartIdType extends IdType
{
    public static function getTypeName(): string
    {
    return 'shop_cart_id';
    }

public function getIdClass(): string
{
return ShopCartId::class;
}

    public static function getClass(): string
    {
        return ShopCartId::class;
    }
}