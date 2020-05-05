<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Infrastructure;

use JacoBaldrich\AmazonProducts\Domain\Api;
use JacoBaldrich\AmazonProducts\Domain\ApiFactory;

final class AmazonApiFactory implements ApiFactory
{
    public static function create(): Api
    {
        static $api = null;

        if (null === $api) {
            $api = new PAAPI5(
                new RequestTransformer(),
                new ResponseTransformer()
            );
        }

        return $api;
    }
}
