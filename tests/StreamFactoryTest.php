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

namespace FastForward\Http\Message\Factory\Tests;

use FastForward\Http\Message\Factory\StreamFactory;
use FastForward\Http\Message\JsonStream;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @internal
 */
#[CoversClass(StreamFactory::class)]
final class StreamFactoryTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @return void
     */
    #[Test]
    public function createStreamWillDelegateToWrappedFactory(): void
    {
        $content    = 'sample';
        $streamMock = $this->prophesize(StreamInterface::class);

        $innerFactory = $this->prophesize(StreamFactoryInterface::class);
        $innerFactory->createStream($content)
            ->willReturn($streamMock->reveal());

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStream($content);

        self::assertSame($streamMock->reveal(), $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function createStreamFromFileWillDelegateToWrappedFactory(): void
    {
        $filename   = 'test.txt';
        $mode       = 'rb';
        $streamMock = $this->prophesize(StreamInterface::class);

        $innerFactory = $this->prophesize(StreamFactoryInterface::class);
        $innerFactory->createStreamFromFile($filename, $mode)
            ->willReturn($streamMock->reveal());

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStreamFromFile($filename, $mode);

        self::assertSame($streamMock->reveal(), $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function createStreamFromResourceWillDelegateToWrappedFactory(): void
    {
        $resource   = fopen('php://temp', 'r');
        $streamMock = $this->prophesize(StreamInterface::class);

        $innerFactory = $this->prophesize(StreamFactoryInterface::class);
        $innerFactory->createStreamFromResource($resource)
            ->willReturn($streamMock->reveal());

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStreamFromResource($resource);

        self::assertSame($streamMock->reveal(), $result);

        fclose($resource);
    }

    /**
     * @return void
     */
    #[Test]
    public function createStreamFromPayloadWillReturnJsonStream(): void
    {
        $payload      = [
            'key' => 'value',
        ];
        $innerFactory = $this->prophesize(StreamFactoryInterface::class);

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStreamFromPayload($payload);

        self::assertInstanceOf(JsonStream::class, $result);
        self::assertSame($payload, $result->getPayload());
    }
}
