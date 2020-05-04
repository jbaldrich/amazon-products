<?php declare(strict_types=1);

namespace JacoBaldrich\BasePlugin\Infrastructure;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use GuzzleHttp\Client;
use JacoBaldrich\BasePlugin\Domain\Api;
use JacoBaldrich\BasePlugin\Application\ItemsResponse;
use JacoBaldrich\BasePlugin\Domain\Request;
use JacoBaldrich\BasePlugin\Domain\Response;

final class PAAPI5 implements Api
{
    private $api;
    private $requestTransformer;
    private $responseTransformer;

    public function __construct(RequestTransformer $requestTransformer, ResponseTransformer $responseTransformer)
    {
        $this->requestTransformer = $requestTransformer;
        $this->responseTransformer = $responseTransformer;
        $this->api = new DefaultApi(
            new Client(),
            $this->configuration()
        );
    }

    public function ask(Request $request): Response
    {
        $searchRequest = $this->requestTransformer->transform($request);
        try {
            $this->validateSearchRequest($searchRequest);
            $searchResponse = $this->api->searchItemsWithHttpInfo($searchRequest);
            return $this->responseTransformer->transform($searchResponse);
        } catch (\Exception $e) {
            return new ItemsResponse([], false);
        }
    }

    private function configuration(): Configuration
    {
        $config = new Configuration();
        $config->setAccessKey(getenv('ACCESS_KEY'));
        $config->setSecretKey(getenv('SECRET_KEY'));

        /*
         * PAAPI host and region to which you want to send request
         * For more details refer:
         * https://webservices.amazon.com/paapi5/documentation/common-request-parameters.html#host-and-region
         */
        $config->setHost('webservices.amazon.es');
        $config->setRegion('eu-west-1');
        return $config;
    }

    private function validateSearchRequest(SearchItemsRequest $searchRequest)
    {
        if (0 < count($searchRequest->listInvalidProperties())) {
            throw new \Exception('Invalid list of proprieties');
        }
    }
}
