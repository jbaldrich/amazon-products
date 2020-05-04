<?php declare(strict_types=1);

namespace JacoBaldrich\BasePlugin\Infrastructure;

use JacoBaldrich\BasePlugin\Domain\Api;
use JacoBaldrich\BasePlugin\Domain\ApiFactory;

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