<?php declare(strict_types=1);

namespace Tests\JacoBaldrich\AmazonProducts;

use Hamcrest\Matcher;
use Hamcrest\Matchers;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Brain\Monkey;

abstract class TestCase extends PHPUnitTestCase
{
    use MockeryPHPUnitIntegration;

    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    protected function mock(string $class): MockInterface
    {
        return Mockery::mock($class);
    }

    /**
     * @param string $functionName
     * @param mixed|null $returnValue
     */
    protected function mockFunction(string $functionName, $returnValue = null): void
    {
        Monkey\Functions\when($functionName)->justReturn($returnValue);
    }

    /**
     * @param mixed $value
     * @return Matcher
     */
    protected function similarTo($value): Matcher
    {
        return Matchers::equalTo($value);
    }
}
