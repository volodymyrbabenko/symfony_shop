<?php

declare(strict_types=1);
namespace App\Domain\ChangeCartItemCount;

use App\DomainService\UserCollection;
use App\Entity\NewsArticle;
use App\Repository\ShopCartRepository;
use App\Repository\ShopItemsRepository;
use App\Time\Clock\ClockInterface;
use App\ValueObject\NewsArticleId;
use DigitalCraftsman\CQRS\Command\Command;
use DigitalCraftsman\CQRS\Command\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

final class ChangeCartItemCountCommandHandler implements CommandHandlerInterface
{
    private ShopItemsRepository $shopItemsRepository;
    private ShopCartRepository $cartRepository;

    public function __construct(
        private EntityManagerInterface $entityManager,
        ShopItemsRepository $shopItemsRepository,
        ShopCartRepository $cartRepository
    ) {
        $this->shopItemsRepository = $shopItemsRepository;
        $this->cartRepository = $cartRepository;
    }

    /** @param ChangeCartItemCountCommand $command */
    public function __invoke(Command $command): void
    {
        // Validate
        if($command->count <= 0) {
            throw new \LogicException('Count cannot be less than or equal to zero');
        }

        // Apply
        $this->ChangeCartItemCount($command);
    }

    private function ChangeCartItemCount(ChangeCartItemCountCommand $command ): void {
        $cart = $this->cartRepository->findOneBy(['id' => $command->id]);
        $cart->setCount($command->count);
        $this->entityManager->flush();
    }
}