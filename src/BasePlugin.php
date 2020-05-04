<?php declare (strict_types = 1);

namespace JacoBaldrich\BasePlugin;

use Dotenv\Dotenv;
use JacoBaldrich\BasePlugin\Application\ItemSearcher;
use JacoBaldrich\BasePlugin\Infrastructure\AmazonApiFactory;
use JacoBaldrich\BasePlugin\Infrastructure\TemplateViewFactory;
use JacoBaldrich\BasePlugin\Infrastructure\WPPath;

final class BasePlugin implements Plugin
{
    private const HOOK = 'plugins_loaded';

    public function register(): void
    {
        \add_action(
            self::HOOK,
            $this
        );
    }

    public function __invoke(): void
    {
        if (! $this->dependenciesAreInstalled()) {
            return;
        }

        // Load .env files
        Dotenv::createImmutable(dirname(__FILE__, 2))->load();

        // Instantiate dependencies
        $apiFactory = new AmazonApiFactory();
        $viewFactory = new TemplateViewFactory();
        $wpPath = WPPath::create('', '');

        // Register use cases
        $itemSearcher = new ItemSearcher($apiFactory, $viewFactory, $wpPath);
        $itemSearcher->register();
    }

    private function dependenciesAreInstalled(): bool
    {
        return true; // check main class dependencies
    }
}
