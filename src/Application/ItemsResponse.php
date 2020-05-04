<?php declare(strict_types=1);

namespace JacoBaldrich\BasePlugin\Application;

use JacoBaldrich\BasePlugin\Domain\Response;

final class ItemsResponse implements Response
{
    private $items;
    private $isSuccessful;

    public function __construct(array $items, bool $isSuccessful)
    {
        $this->items = $items;
        $this->isSuccessful = $isSuccessful;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }
}
