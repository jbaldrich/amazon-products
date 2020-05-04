<?php declare (strict_types = 1);

namespace JacoBaldrich\BasePlugin\Infrastructure;

use JacoBaldrich\BasePlugin\Domain\Path;
use JacoBaldrich\BasePlugin\Domain\View;
use stdClass;

class TemplateView implements View
{
    /** @var Path */
    private $path;
    /** @var stdClass */
    private $context;

    public function __construct(Path $path)
    {
        $this->path = $path;
    }

    public function render(stdClass $context): string
    {
        $this->context = $context;
        \ob_start();
        include $this->path->filePath();
        return \ob_get_clean() ?: '';
    }
}
