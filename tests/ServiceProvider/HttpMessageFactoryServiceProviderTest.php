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
use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * @internal
 */
#[CoversClass(HttpMessageFactoryServiceProvider::class)]
final class HttpMessageFactoryServiceProviderTest extends TestCase
{
    public function testGetFactoriesReturnsExpectedMappings(): void
    {
        $provider  = new HttpMessageFactoryServiceProvider();
        $factories = $provider->getFactories();

        self::assertArrayHasKey(Psr17Factory::class, $factories);
        self::assertInstanceOf(InvokableFactory::class, $factories[Psr17Factory::class]);

        self::assertArrayHasKey(ServerRequestCreator::class, $factories);
        self::assertInstanceOf(InvokableFactory::class, $factories[ServerRequestCreator::class]);

        self::assertArrayHasKey(ServerRequestInterface::class, $factories);
        self::assertInstanceOf(MethodFactory::class, $factories[ServerRequestInterface::class]);

        $aliases = [
            RequestFactoryInterface::class,
            ResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            StreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
            UriFactoryInterface::class,
        ];

        foreach ($aliases as $alias) {
            self::assertArrayHasKey($alias, $factories);
            self::assertInstanceOf(AliasFactory::class, $factories[$alias]);
        }
    }

    public function testGetExtensionsReturnsEmptyArray(): void
    {
        $provider = new HttpMessageFactoryServiceProvider();
        self::assertSame([], $provider->getExtensions());
    }
}
