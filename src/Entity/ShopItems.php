<?php

namespace App\Entity;

use App\Repository\ShopItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopItemsRepository::class)]
class ShopItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'shopItem', targetEntity: ShopCart::class, orphanRemoval: true)]
    private Collection $shopCarts;

    public function __construct()
    {
        $this->shopCarts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ShopCart>
     */
    public function getShopCarts(): Collection
    {
        return $this->shopCarts;
    }

    public function addShopCart(ShopCart $shopCart): static
    {
        if (!$this->shopCarts->contains($shopCart)) {
            $this->shopCarts->add($shopCart);
            $shopCart->setShopItem($this);
        }

        return $this;
    }

    public function removeShopCart(ShopCart $shopCart): static
    {
        if ($this->shopCarts->removeElement($shopCart)) {
            // set the owning side to null (unless already changed)
            if ($shopCart->getShopItem() === $this) {
                $shopCart->setShopItem(null);
            }
        }

        return $this;
    }
}
