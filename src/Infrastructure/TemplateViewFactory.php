<?php declare (strict_types = 1);

namespace JacoBaldrich\BasePlugin\Infrastructure;

use JacoBaldrich\BasePlugin\Domain\Path;
use JacoBaldrich\BasePlugin\Domain\View;
use JacoBaldrich\BasePlugin\Domain\ViewFactory;

class TemplateViewFactory implements ViewFactory
{
    public function create(Path $path): View
    {
        return new TemplateView($path);
    }
}
