<?php declare(strict_types=1);

namespace JacoBaldrich\AmazonProducts\Application;

use JacoBaldrich\AmazonProducts\Domain\Api;
use JacoBaldrich\AmazonProducts\Domain\ApiFactory;
use JacoBaldrich\AmazonProducts\Domain\Path;
use JacoBaldrich\AmazonProducts\Domain\View;
use JacoBaldrich\AmazonProducts\Domain\ViewFactory;

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
        \add_shortcode('amazoner', $this);
    }

    public function __invoke(array $attributes): void
    {
        $attributes = $this->mergeWithDefaultAttributes($attributes);

        $request = new ItemsRequest(
            $attributes['keyword'],
            (int) $attributes['page']
        );

        $api = $this->createApi();
        /** @var ItemsResponse $response */
        $response = $api->ask($request);

        if ($response->isSuccessful()) {
            $context = new \stdClass();
            $context->items = $response->items();
            $view = $this->createView();
            // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
            echo $view->render($context);
        }
    }

    private function mergeWithDefaultAttributes(array $attributes): array
    {
        global $post;
        return \shortcode_atts(
            [
                'keyword' => $post->post_name ?? 'caca',
                'page'   => 1,
            ],
            $attributes,
            'amazoner'
        );
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
