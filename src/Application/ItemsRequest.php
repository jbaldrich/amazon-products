<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Application;

use JacoBaldrich\AmazonProducts\Domain\Request;

final class ItemsRequest implements Request
{
    private $keyword;
    private $page;

    public function __construct(string $keyword, int $page)
    {
        $this->keyword = $keyword;
        $this->page = $page;
    }

    public function keyword(): string
    {
        return $this->keyword;
    }

    public function page(): int
    {
        return $this->page;
    }
}
