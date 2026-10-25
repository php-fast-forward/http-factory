<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/http-factory.
 *
 * This source file is subject to the license bundled
 * with this source code in the file LICENSE.
 *
 * @copyright Copyright (c) 2025-2026 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 *
 * @see       https://github.com/php-fast-forward/http-factory
 * @see       https://github.com/php-fast-forward
 * @see       https://datatracker.ietf.org/doc/html/rfc2119
 */

namespace FastForward\Http\Message\Factory\Tests\ServiceProvider;

use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
use FastForward\Http\Message\Factory\StreamFactoryInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\ServerRequest;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

#[CoversClass(HttpMessageFactoryServiceProvider::class)]
final class ServerRequestFactoryWiringTest extends TestCase
{
    /**
     * Separate PSR-17 implementations must not make request creation and
     * server-request creation depend on the same container service.
     */
    public function testCreatorUsesTheIndependentlyConfiguredServerRequestFactory(): void
    {
        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->expects(self::never())->method('createRequest');
        $serverFactory = $this->createMock(ServerRequestFactoryInterface::class);
        $expected = new ServerRequest('GET', 'https://example.test/');
        $serverFactory->expects(self::once())->method('createServerRequest')->willReturn($expected);
        $psr17 = new Psr17Factory();
        $services = [
            RequestFactoryInterface::class => $requestFactory,
            ServerRequestFactoryInterface::class => $serverFactory,
            UriFactoryInterface::class => $psr17,
            UploadedFileFactoryInterface::class => $psr17,
            StreamFactoryInterface::class => $psr17,
        ];
        $container = self::createStub(ContainerInterface::class);
        $container->method('has')
            ->willReturnCallback(static fn(string $id): bool => isset($services[$id]));
        $container->method('get')
            ->willReturnCallback(static fn(string $id): mixed => $services[$id]);
        $factory = (new HttpMessageFactoryServiceProvider())->getFactories()[ServerRequestCreator::class];

        $creator = $factory($container);
        $response = $creator->fromArrays([
            'REQUEST_METHOD' => 'GET',
            'HTTP_HOST' => 'example.test',
            'REQUEST_URI' => '/',
        ]);

        self::assertSame('GET', $response->getMethod());
        self::assertSame('example.test', $response->getUri()->getHost());
    }
}
