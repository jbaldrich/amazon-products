<?php declare(strict_types=1);

namespace JacoBaldrich\BasePlugin\Application;

use JacoBaldrich\BasePlugin\Domain\Api;
use JacoBaldrich\BasePlugin\Domain\ApiFactory;
use JacoBaldrich\BasePlugin\Domain\Path;
use JacoBaldrich\BasePlugin\Domain\View;
use JacoBaldrich\BasePlugin\Domain\ViewFactory;

final class ItemSearcher implements Service
{
    private $apiFactory;
    private $viewFactory;
    private $path;

    public function __construct(ApiFactory $apiFactory, ViewFactory $viewFactory, Path $path)
    {
        $this->apiFactory = $apiFactory;
        $this->viewFactory = $viewFactory;
        $this->path = $path;
    }


    public function register(): void
    {
        \add_shortcode( 'amazoner', $this );
    }

    public function __invoke(array $attributes): void
    {
        $attributes = $this->mergeWithDefaultAttributes($attributes);

        $request = new ItemsRequest(
            $attributes['keyword'],
            (int) $attributes['items']
        );

        $api = $this->createApi();
        $response = $api->ask($request);

        if ($response->isSuccessful()) {
            $context = new \stdClass();
            $context->items = $response->items();
            $view = $this->createView();
            echo $view->render($context);
        }
    }

    private function mergeWithDefaultAttributes(array $attributes): array
    {
        global $post;
        return shortcode_atts([
            'keyword' => $post->post_name,
            'items'   => 8,
        ], $attributes, 'amazoner');
    }

    private function createApi(): Api
    {
        return $this->apiFactory::create();
    }

    private function createView(): View
    {
        return $this->viewFactory->create(
            $this->path::create(
                'item.php',
                'templates'
            )
        );
    }
}
