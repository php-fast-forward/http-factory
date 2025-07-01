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

namespace FastForward\Http\Message\Factory\Tests;

use FastForward\Http\Message\Factory\StreamFactory;
use FastForward\Http\Message\JsonStream;
use PHPUnit\Framework\Attributes\CoversClass;
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

    public function testCreateStreamWillDelegateToWrappedFactory(): void
    {
        $content    = 'sample';
        $streamMock = $this->prophesize(StreamInterface::class);

        $innerFactory = $this->prophesize(StreamFactoryInterface::class);
        $innerFactory->createStream($content)->willReturn($streamMock->reveal());

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStream($content);

        self::assertSame($streamMock->reveal(), $result);
    }

    public function testCreateStreamFromFileWillDelegateToWrappedFactory(): void
    {
        $filename   = 'test.txt';
        $mode       = 'rb';
        $streamMock = $this->prophesize(StreamInterface::class);

        $innerFactory = $this->prophesize(StreamFactoryInterface::class);
        $innerFactory->createStreamFromFile($filename, $mode)->willReturn($streamMock->reveal());

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStreamFromFile($filename, $mode);

        self::assertSame($streamMock->reveal(), $result);
    }

    public function testCreateStreamFromResourceWillDelegateToWrappedFactory(): void
    {
        $resource   = fopen('php://temp', 'r');
        $streamMock = $this->prophesize(StreamInterface::class);

        $innerFactory = $this->prophesize(StreamFactoryInterface::class);
        $innerFactory->createStreamFromResource($resource)->willReturn($streamMock->reveal());

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStreamFromResource($resource);

        self::assertSame($streamMock->reveal(), $result);

        fclose($resource);
    }

    public function testCreateStreamFromPayloadWillReturnJsonStream(): void
    {
        $payload      = ['key' => 'value'];
        $innerFactory = $this->prophesize(StreamFactoryInterface::class);

        $factory = new StreamFactory($innerFactory->reveal());

        $result = $factory->createStreamFromPayload($payload);

        self::assertInstanceOf(JsonStream::class, $result);
        self::assertSame($payload, $result->getPayload());
    }
}
