<?php declare (strict_types = 1);

namespace JacoBaldrich\AmazonProducts\Infrastructure;

use JacoBaldrich\AmazonProducts\Domain\Path;
use JacoBaldrich\AmazonProducts\Domain\View;
use JacoBaldrich\AmazonProducts\Domain\ViewFactory;

class TemplateViewFactory implements ViewFactory
{
    public function create(Path $path): View
    {
        return new TemplateView($path);
    }
}
