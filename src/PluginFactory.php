<?php declare( strict_types=1 );

namespace JacoBaldrich\AmazonProducts;

final class PluginFactory
{
    public static function create(): Plugin
    {
        static $plugin = null;

        if (null === $plugin) {
            $plugin = new AmazonProducts();
        }

        return $plugin;
    }
}
