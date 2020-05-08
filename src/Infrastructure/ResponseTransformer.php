<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Infrastructure;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item as AmazonItem;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResponse;
use JacoBaldrich\AmazonProducts\Domain\Item;
use JacoBaldrich\AmazonProducts\Application\ItemsResponse;

final class ResponseTransformer
{
    public function transform(array $response): ItemsResponse
    {
        $items = [];
        if ($this->hasItems($response)) {
            foreach ($this->items($response[0]) as $item) {
                $items[] = new Item(
                    $this->itemUrl($item),
                    $this->itemImage($item),
                    $this->itemTitle($item),
                    $this->itemPrice($item),
                    $this->itemFeatures($item),
                    $this->moreLikeThatUrl($response[0])
                );
            }
        }
        return new ItemsResponse(
            $items,
            200 === $response[1]
        );
    }

    private function itemFeatures(AmazonItem $item): array
    {
        if ($this->hasFeatures($item)) {
            return $item->getItemInfo()->getFeatures()->getDisplayValues() ?? [];
        }
        return [];
    }

    private function hasItemInfo(AmazonItem $item): bool
    {
        return null !== $item->getItemInfo();
    }

    private function hasFeatures(AmazonItem $item): bool
    {
        return $this->hasItemInfo($item) && null !== $item->getItemInfo()->getFeatures();
    }

    private function hasItems(array $response): bool
    {
        return $response[0] instanceof SearchItemsResponse
            && is_array($this->items($response[0]));
    }

    private function items(SearchItemsResponse $response): array
    {
        return $response->getSearchResult()->getItems() ?? [];
    }

    private function itemUrl(AmazonItem $item): string
    {
        return $item->getDetailPageURL() ?? '';
    }

    private function itemImage(AmazonItem $item): string
    {
        return $item->getImages()->getPrimary()->getMedium()->getURL() ?? '';
    }

    private function itemTitle(AmazonItem $item): string
    {
        return $item->getItemInfo()->getTitle()->getDisplayValue() ?? '';
    }

    private function itemPrice(AmazonItem $item): string
    {
        return $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount() ?? '';
    }

    private function moreLikeThatUrl(SearchItemsResponse $response): string
    {
        return $response->getSearchResult()->getSearchURL() ?? '';
    }
}
