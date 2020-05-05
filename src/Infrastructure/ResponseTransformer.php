<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Infrastructure;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResponse;
use JacoBaldrich\AmazonProducts\Domain\Item;
use JacoBaldrich\AmazonProducts\Application\ItemsResponse;

final class ResponseTransformer
{
    public function transform(array $response): ItemsResponse
    {
        $items = [];
        if ($response[0] instanceof SearchItemsResponse) {
            foreach ($response[0]->getSearchResult()->getItems() as $item) {
                $items[] = new Item(
                    $item->getDetailPageURL(),
                    $item->getImages()->getPrimary()->getMedium()->getURL(),
                    $item->getItemInfo()->getTitle()->getDisplayValue(),
                    $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount(),
                    $item->getItemInfo()->getFeatures()->getDisplayValues(),
                    $response[0]->getSearchResult()->getSearchURL()
                );
            }
        }
        return new ItemsResponse(
            $items,
            $response[1] === 200
        );
    }
}
