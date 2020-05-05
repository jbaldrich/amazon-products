<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Application;

use JacoBaldrich\AmazonProducts\Domain\Request;

final class ItemsRequest implements Request
{
    private $keyword;
    private $itemsQuantity;

    public function __construct(string $keyword, int $itemsQuantity)
    {
        $this->keyword = $keyword;
        $this->itemsQuantity = $itemsQuantity;
    }

    public function keyword(): string
    {
        return $this->keyword;
    }

    public function itemsQuantity(): int
    {
        return $this->itemsQuantity;
    }
}
