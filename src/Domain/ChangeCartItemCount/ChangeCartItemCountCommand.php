<?php
declare(strict_types=1);
namespace App\Domain\ChangeCartItemCount;

use App\Helper\HtmlHelper;
use App\ValueObject\UserId;
use Assert\Assertion;
use DigitalCraftsman\CQRS\Command\Command;

final class ChangeCartItemCountCommand implements Command
{
    public function __construct(
        public string $id,
        public int $count,

    ) {
        Assertion::notEmpty($id);
        Assertion::integer($count);
    }
}