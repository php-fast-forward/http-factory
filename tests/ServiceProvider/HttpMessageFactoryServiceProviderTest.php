<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/http-factory.
 *
 * This source file is subject to the license bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/php-fast-forward/http-factory
 * @copyright Copyright (c) 2025 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace FastForward\Http\Message\Factory\Tests\ServiceProvider;

use FastForward\Container\Factory\AliasFactory;
use FastForward\Container\Factory\InvokableFactory;
use FastForward\Container\Factory\MethodFactory;
use FastForward\Container\ServiceProviderContainer;
use FastForward\Http\Message\Factory\ResponseFactory;
use FastForward\Http\Message\Factory\ResponseFactoryInterface;
use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
use FastForward\Http\Message\Factory\StreamFactory;
use FastForward\Http\Message\Factory\StreamFactoryInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface as PsrStreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * @internal
 */
#[CoversClass(HttpMessageFactoryServiceProvider::class)]
#[UsesClass(ResponseFactory::class)]
#[UsesClass(StreamFactory::class)]
final class HttpMessageFactoryServiceProviderTest extends TestCase
{
    use ProphecyTrait;

    private HttpMessageFactoryServiceProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new HttpMessageFactoryServiceProvider();
    }

    public function testGetFactoriesReturnsExpectedMappings(): void
    {
        $factories = $this->provider->getFactories();

        self::assertArrayHasKey(Psr17Factory::class, $factories);
        self::assertInstanceOf(InvokableFactory::class, $factories[Psr17Factory::class]);

        self::assertArrayHasKey(ServerRequestCreator::class, $factories);
        self::assertInstanceOf(InvokableFactory::class, $factories[ServerRequestCreator::class]);

        self::assertArrayHasKey(ServerRequestInterface::class, $factories);
        self::assertInstanceOf(MethodFactory::class, $factories[ServerRequestInterface::class]);

        $aliases = [
            RequestFactoryInterface::class,
            PsrResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            PsrStreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
            UriFactoryInterface::class,
            ResponseFactoryInterface::class,
            StreamFactoryInterface::class,
        ];

        foreach ($aliases as $alias) {
            self::assertArrayHasKey($alias, $factories);
            self::assertInstanceOf(AliasFactory::class, $factories[$alias]);
        }
    }

    public function testGetExtensionsReturnsEmptyArray(): void
    {
        self::assertSame([], $this->provider->getExtensions());
    }

    // Funcional test to ensure that the container resolves aliases correctly
    public function testFunctionalGetFactoryReturnInstanceOfService(): void
    {
        $container = new ServiceProviderContainer($this->provider);

        foreach ($this->provider->getFactories() as $alias => $factory) {
            self::assertTrue($container->has($alias), "Container does not have alias: {$alias}");

            $object = $container->get($alias);

            self::assertNotNull($object, "Failed to resolve alias: {$alias}");
            self::assertInstanceOf($alias, $object, "Resolved object is not an instance of {$alias}");
        }
    }
}
