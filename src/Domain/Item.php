<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Domain;

final class Item
{
    /** @var string */
    private $url;
    /** @var string */
    private $image;
    /** @var string */
    private $title;
    /** @var string */
    private $price;
    /** @var array */
    private $features;
    /** @var string */
    private $moreLikeThatUrl;

    public function __construct(
        string $url,
        string $image,
        string $title,
        string $price,
        array $features,
        string $moreLikeThatUrl
    ) {

        $this->url = $url;
        $this->image = $image;
        $this->title = $title;
        $this->price = $price;
        $this->features = $features;
        $this->moreLikeThatUrl = $moreLikeThatUrl;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function price(): string
    {
        return $this->price;
    }

    public function features(): array
    {
        return $this->features;
    }

    public function moreLikeThatUrl(): string
    {
        return $this->moreLikeThatUrl;
    }
}
