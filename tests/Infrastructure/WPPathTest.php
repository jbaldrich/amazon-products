<?php declare (strict_types = 1);

namespace Tests\JacoBaldrich\BasePlugin\Infrastructure;

use JacoBaldrich\BasePlugin\Domain\Path;
use JacoBaldrich\BasePlugin\Infrastructure\WPPath;
use PHPUnit\Framework\TestCase;

final class WPPathTest extends TestCase
{
    /** @var string */
    private $path;
    /** @var string */
    private $file;
    /** @var Path */
    private $instance;

    public function testPathWithNoSlashes(): void
    {
        $this->givenThePathAndFile('level2/level1', 'file.php');

        $this->whenWeCreateAWPPath();

        $this->thenFilePathShouldReturn('level2/level1/file.php');
    }

    public function testPathWithEndSlash(): void
    {
        $this->givenThePathAndFile('level2/level1/', 'file.php');

        $this->whenWeCreateAWPPath();

        $this->thenFilePathShouldReturn('level2/level1/file.php');
    }

    public function testPathWithStartSlash(): void
    {
        $this->givenThePathAndFile('/level2/level1', 'file.php');

        $this->whenWeCreateAWPPath();

        $this->thenFilePathShouldReturn('level2/level1/file.php');
    }

    public function testPathWithNoFile(): void
    {
        $this->givenThePathAndFile('level2/level1', '');

        $this->whenWeCreateAWPPath();

        $this->thenFilePathShouldReturn('level2/level1/');
    }

    public function testPathWithNoRelativePath(): void
    {
        $this->givenThePathAndFile('', 'file.php');

        $this->whenWeCreateAWPPath();

        $this->thenFilePathShouldReturn('file.php');
    }

    public function testWithNoRelativePathNorFile(): void
    {
        $this->givenThePathAndFile('', '');

        $this->whenWeCreateAWPPath();

        $this->thenFilePathShouldReturn('');
    }

    private function givenThePathAndFile(string $path, string $file): void
    {
        $this->path = $path;
        $this->file = $file;
    }

    private function whenWeCreateAWPPath(): void
    {
        $this->instance = WPPath::create($this->file, $this->path);
    }

    private function thenFilePathShouldReturn(string $expected): void
    {
        $this->assertEquals(
            dirname(__FILE__, 3) . '/' . $expected,
            $this->instance->filePath()
        );
    }
}
