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

namespace FastForward\Http\Message\Factory;

use FastForward\Http\Message\EmptyResponse;
use FastForward\Http\Message\HtmlResponse;
use FastForward\Http\Message\JsonResponse;
use FastForward\Http\Message\PayloadResponseInterface;
use FastForward\Http\Message\RedirectResponse;
use FastForward\Http\Message\TextResponse;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class ResponseFactory.
 *
 * Factory for generating different types of HTTP responses.
 * This class encapsulates a PSR-17 response factory and provides
 * convenient methods for producing responses with content, payloads, redirects, or no content.
 *
 * @package FastForward\Http\Message\Factory
 */
final class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * Constructs the ResponseFactory.
     *
     * @param PsrResponseFactoryInterface $responseFactory the underlying PSR-17 response factory implementation
     */
    public function __construct(
        private PsrResponseFactoryInterface $responseFactory,
    ) {}

    /**
     * Creates a standard HTTP response.
     *
     * @param int    $code         The HTTP status code. Defaults to 200 (OK).
     * @param string $reasonPhrase optional reason phrase
     *
     * @return ResponseInterface the generated response
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->responseFactory->createResponse($code, $reasonPhrase);
    }

    /**
     * Creates an HTTP response containing HTML content.
     *
     * The response SHALL have 'Content-Type: text/html' set automatically.
     *
     * @param string $html the HTML content to include in the response body
     *
     * @return ResponseInterface the generated HTML response
     */
    public function createResponseFromHtml(string $html): ResponseInterface
    {
        return new HtmlResponse($html);
    }

    /**
     * Creates an HTTP response containing plain text content.
     *
     * The response SHALL have 'Content-Type: text/plain' set automatically.
     *
     * @param string $text the plain text content to include in the response body
     *
     * @return ResponseInterface the generated plain text response
     */
    public function createResponseFromText(string $text): ResponseInterface
    {
        return new TextResponse($text);
    }

    /**
     * Creates an HTTP 204 No Content response.
     *
     * This response SHALL contain no body and have status code 204.
     *
     * @param array<string, string|string[]> $headers optional headers to include
     *
     * @return ResponseInterface the generated no content response
     */
    public function createResponseNoContent(array $headers = []): ResponseInterface
    {
        return new EmptyResponse($headers);
    }

    /**
     * Creates an HTTP response containing a JSON-encoded payload.
     *
     * The response SHALL have 'Content-Type: application/json' set automatically.
     *
     * @param array $payload the payload to encode as JSON
     *
     * @return PayloadResponseInterface the generated JSON response
     */
    public function createResponseFromPayload(array $payload): PayloadResponseInterface
    {
        return new JsonResponse($payload);
    }

    /**
     * Creates an HTTP redirect response.
     *
     * The response SHALL include a 'Location' header and appropriate status code.
     * By default, a temporary (302) redirect is issued unless $permanent is true.
     *
     * @param string|UriInterface            $uri       the target location for the redirect
     * @param bool                           $permanent whether to issue a permanent (301) redirect
     * @param array<string, string|string[]> $headers   optional additional headers
     *
     * @return ResponseInterface the generated redirect response
     */
    public function createResponseRedirect(
        string|UriInterface $uri,
        bool $permanent = false,
        array $headers = [],
    ): ResponseInterface {
        return new RedirectResponse($uri, $permanent, $headers);
    }
}
