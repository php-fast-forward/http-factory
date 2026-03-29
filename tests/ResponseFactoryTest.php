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

use FastForward\Http\Message\EmptyResponse;
use FastForward\Http\Message\Factory\ResponseFactory;
use FastForward\Http\Message\HtmlResponse;
use FastForward\Http\Message\JsonResponse;
use FastForward\Http\Message\RedirectResponse;
use FastForward\Http\Message\TextResponse;
use Nyholm\Psr7\Uri;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
#[CoversClass(ResponseFactory::class)]
final class ResponseFactoryTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @return void
     */
    #[Test]
    public function createResponseDelegatesToInnerFactory(): void
    {
        $response = $this->prophesize(ResponseInterface::class);

        $innerFactory = $this->prophesize(PsrResponseFactoryInterface::class);
        $innerFactory->createResponse(201, 'Created')
            ->willReturn($response->reveal());

        $factory = new ResponseFactory($innerFactory->reveal());

        $result = $factory->createResponse(201, 'Created');

        self::assertSame($response->reveal(), $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function createResponseFromHtmlReturnsHtmlResponse(): void
    {
        $html         = '<h1>Title</h1>';
        $innerFactory = $this->prophesize(PsrResponseFactoryInterface::class);

        $factory = new ResponseFactory($innerFactory->reveal());

        $result = $factory->createResponseFromHtml($html);

        self::assertInstanceOf(HtmlResponse::class, $result);
        self::assertSame($html, (string) $result->getBody());
    }

    /**
     * @return void
     */
    #[Test]
    public function createResponseFromTextReturnsTextResponse(): void
    {
        $text         = 'Plain Text';
        $innerFactory = $this->prophesize(PsrResponseFactoryInterface::class);

        $factory = new ResponseFactory($innerFactory->reveal());

        $result = $factory->createResponseFromText($text);

        self::assertInstanceOf(TextResponse::class, $result);
        self::assertSame($text, (string) $result->getBody());
    }

    /**
     * @return void
     */
    #[Test]
    public function createResponseNoContentReturnsEmptyResponse(): void
    {
        $headers      = [
            'X-Test' => 'value',
        ];
        $innerFactory = $this->prophesize(PsrResponseFactoryInterface::class);

        $factory = new ResponseFactory($innerFactory->reveal());

        $result = $factory->createResponseNoContent($headers);

        self::assertInstanceOf(EmptyResponse::class, $result);
        self::assertSame('value', $result->getHeaderLine('X-Test'));
    }

    /**
     * @return void
     */
    #[Test]
    public function createResponseFromPayloadReturnsJsonResponse(): void
    {
        $payload      = [
            'key' => 'value',
        ];
        $innerFactory = $this->prophesize(PsrResponseFactoryInterface::class);

        $factory = new ResponseFactory($innerFactory->reveal());

        $result = $factory->createResponseFromPayload($payload);

        self::assertInstanceOf(JsonResponse::class, $result);
        self::assertSame($payload, $result->getPayload());
    }

    /**
     * @return void
     */
    #[Test]
    public function createResponseRedirectAcceptsStringUri(): void
    {
        $innerFactory = $this->prophesize(PsrResponseFactoryInterface::class);

        $factory = new ResponseFactory($innerFactory->reveal());

        $result = $factory->createResponseRedirect('https://example.com');

        self::assertInstanceOf(RedirectResponse::class, $result);
        self::assertSame('https://example.com', $result->getHeaderLine('Location'));
    }

    /**
     * @return void
     */
    #[Test]
    public function createResponseRedirectAcceptsUriObject(): void
    {
        $uri          = new Uri('/relative/path');
        $headers      = [
            'X-Test' => 'value',
        ];
        $innerFactory = $this->prophesize(PsrResponseFactoryInterface::class);

        $factory = new ResponseFactory($innerFactory->reveal());

        $result = $factory->createResponseRedirect($uri, true, $headers);

        self::assertInstanceOf(RedirectResponse::class, $result);
        self::assertSame('/relative/path', $result->getHeaderLine('Location'));
        self::assertSame('value', $result->getHeaderLine('X-Test'));
    }
}
