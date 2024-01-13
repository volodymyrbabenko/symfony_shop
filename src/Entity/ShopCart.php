<?php

namespace App\Entity;

use App\Repository\ShopCartRepository;
use App\ValueObject\ShopCartId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopCartRepository::class)]
class ShopCart
{

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'shop_cart_id')]
    public ShopCartId $id;

    #[ORM\Column(length: 255)]
    private ?string $sessionId = null;

    #[ORM\ManyToOne(inversedBy: 'shopCarts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShopItems $shopItem = null;

    #[ORM\Column]
    private ?int $count = null;

    public function getId(): ShopCartId
    {
        return $this->id;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getShopItem(): ?ShopItems
    {
        return $this->shopItem;
    }

    public function setShopItem(?ShopItems $shopItem): static
    {
        $this->shopItem = $shopItem;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function setId(ShopCartId $id)
    {
        $this->id = $id;

        return $this;
    }
}
