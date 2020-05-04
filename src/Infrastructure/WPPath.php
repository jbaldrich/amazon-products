<?php declare (strict_types = 1);

namespace JacoBaldrich\BasePlugin\Infrastructure;

use JacoBaldrich\BasePlugin\Domain\Path;
use JacoBaldrich\BasePlugin\Domain\URL;

final class WPPath implements Path, URL
{
    private const LEVELS_UP = 3;
    private const CURRENT_FILE = __FILE__;
    private $file;
    private $path;

    private function __construct(string $file, string $path)
    {
        $path = $this->absolutePath($path);
        $this->file = $file;
        $this->path = $path;
    }

    public static function create(string $file, string $relativePath): Path
    {
        return new self($file, $relativePath);
    }

    public function filePath(): string
    {
        return $this->path() . $this->file();
    }

    public function fileURL(): string
    {
        return $this->urlFromPath();
    }

    private function file(): string
    {
        return $this->file;
    }

    private function path(): string
    {
        return $this->path;
    }

    private function absolutePath(string $relativePath): string
    {
        $relativePath = $this->cleanPath($relativePath);
        return $this->cleanPath($this->basePath() . $relativePath);
    }

    private function cleanPath(string $path): string
    {
        $path = \rtrim($path, '/\\');
        $path = \ltrim($path, '/\\');
        return '/' . $path . '/';
    }

    private function basePath(): string
    {
        return \dirname(self::CURRENT_FILE, self::LEVELS_UP);
    }

    private function urlFromPath(): string
    {
        return \plugin_dir_url($this->filePath()) . $this->file();
    }
}
