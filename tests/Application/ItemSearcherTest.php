<?php declare (strict_types = 1);

namespace Tests\JacoBaldrich\AmazonProducts\Application;

use JacoBaldrich\AmazonProducts\Application\ItemSearcher;
use JacoBaldrich\AmazonProducts\Application\ItemsRequest;
use JacoBaldrich\AmazonProducts\Domain\Api;
use JacoBaldrich\AmazonProducts\Domain\ApiFactory;
use JacoBaldrich\AmazonProducts\Domain\Item;
use JacoBaldrich\AmazonProducts\Domain\Path;
use JacoBaldrich\AmazonProducts\Domain\Response;
use JacoBaldrich\AmazonProducts\Domain\View;
use JacoBaldrich\AmazonProducts\Domain\ViewFactory;
use stdClass;
use Tests\JacoBaldrich\AmazonProducts\TestCase;

final class ItemSearcherTest extends TestCase
{
    /** @test */
    public function isShouldRenderTheTemplateWithAmazonItems(): void
    {
        $keyword = 'cucumber';
        $page = 3;
        $attributes = [
            'keyword' => $keyword,
            'page'   => $page,
        ];
        $expectedOutput = 'eggplant';

        $this->mockFunction('shortcode_atts', $attributes);
        $this->mockGlobalPost();

        $request = new ItemsRequest($keyword, $page);

        $response = $this->mock(Response::class);
        $response->expects()->isSuccessful()->andReturnTrue();
        $response->expects()->items()->andReturn($this->items());

        $api = $this->mock(Api::class);
        $api->expects()->ask($this->similarTo($request))->andReturn($response);

        $apiFactory = $this->mock(ApiFactory::class);
        $apiFactory->expects()->create()->andReturn($api);

        $view = $this->mock(View::class);
        $view->expects()->render($this->similarTo($this->context()))->andReturn($expectedOutput);

        $path = $this->mock(Path::class);
        $path->expects()->create('item.php', 'templates')->andReturnSelf();

        $viewFactory = $this->mock(ViewFactory::class);
        $viewFactory->expects()->create($path)->andReturn($view);

        $itemSearcher = new ItemSearcher($apiFactory, $viewFactory, $path);

        $this->expectOutputString($expectedOutput);

        $itemSearcher($attributes);
    }

    private function items(): array
    {
        return [
            new Item('url', 'image', 'title', 'price', ['feature'], 'moreLikeUrl'),
        ];
    }

    private function context(): stdClass
    {
        $context = new \stdClass();
        $context->items = $this->items();
        return $context;
    }

    private function mockGlobalPost(): void
    {
        global $post;
        $post = new stdClass();
        $post->post_name = '';
    }
}
