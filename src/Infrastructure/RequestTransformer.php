<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Infrastructure;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResource;
use JacoBaldrich\AmazonProducts\Application\ItemsRequest;

final class RequestTransformer
{
    /*
     * Specify the category in which search request is to be made
     * For more details, refer:
     * https://webservices.amazon.com/paapi5/documentation/use-cases/organization-of-items-on-amazon/search-index.html
     */
    const SEARCH_INDEX = 'All';

    public function transform(ItemsRequest $request): SearchItemsRequest
    {
        $searchItemsRequest = new SearchItemsRequest();
        $searchItemsRequest->setSearchIndex(self::SEARCH_INDEX);
        $searchItemsRequest->setKeywords($request->keyword());
        $searchItemsRequest->setItemCount($request->itemsQuantity());
        $searchItemsRequest->setPartnerTag(getenv('PARTNER_TAG') ?: '');
        $searchItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
        $searchItemsRequest->setResources($this->resources());
        return $searchItemsRequest;
    }

    public function resources(): array
    {
        /*
         * Choose resources you want from SearchItemsResource enum
         * For more details, refer:
         * https://webservices.amazon.com/paapi5/documentation/search-items.html#resources-parameter
         */
        return [
            SearchItemsResource::BROWSE_NODE_INFOBROWSE_NODES,
            SearchItemsResource::ITEM_INFOTITLE,
            SearchItemsResource::ITEM_INFOFEATURES,
            SearchItemsResource::IMAGESPRIMARYMEDIUM,
            SearchItemsResource::OFFERSLISTINGSPRICE,
        ];
    }
}
