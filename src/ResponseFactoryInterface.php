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

use FastForward\Http\Message\PayloadResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Interface ResponseFactoryInterface.
 *
 * Extends PSR-17 ResponseFactoryInterface and defines additional convenience methods
 * for generating common types of HTTP responses, including HTML, plain text, JSON payloads,
 * redirects, and empty responses.
 *
 * Implementations of this interface MUST comply with the method requirements and MUST return
 * immutable instances as per PSR-7 standards.
 */
interface ResponseFactoryInterface extends PsrResponseFactoryInterface
{
    /**
     * Creates an HTTP response containing HTML content.
     *
     * The response MUST have 'Content-Type: text/html' set automatically.
     *
     * @param string $html the HTML content to include in the response body
     *
     * @return ResponseInterface the generated HTML response
     */
    public function createResponseFromHtml(string $html): ResponseInterface;

    /**
     * Creates an HTTP response containing a JSON-encoded payload.
     *
     * The response MUST have 'Content-Type: application/json' set automatically.
     *
     * @param array $payload the payload to encode as JSON
     *
     * @return PayloadResponseInterface the generated JSON response
     */
    public function createResponseFromPayload(array $payload): PayloadResponseInterface;

    /**
     * Creates an HTTP response containing plain text content.
     *
     * The response MUST have 'Content-Type: text/plain' set automatically.
     *
     * @param string $text the plain text content to include in the response body
     *
     * @return ResponseInterface the generated plain text response
     */
    public function createResponseFromText(string $text): ResponseInterface;

    /**
     * Creates an HTTP 204 No Content response.
     *
     * The response MUST contain no body and MUST have status code 204.
     *
     * @param array<string, string|string[]> $headers optional headers to include in the response
     *
     * @return ResponseInterface the generated no content response
     */
    public function createResponseNoContent(array $headers): ResponseInterface;

    /**
     * Creates an HTTP redirect response.
     *
     * The response MUST include a 'Location' header and an appropriate status code:
     * 301 (permanent) if $permanent is true, or 302 (temporary) otherwise.
     *
     * @param string|UriInterface            $uri       the target location for the redirect
     * @param bool                           $permanent if true, issues a permanent redirect; otherwise, temporary
     * @param array<string, string|string[]> $headers   optional additional headers to include
     *
     * @return ResponseInterface the generated redirect response
     */
    public function createResponseRedirect(
        string|UriInterface $uri,
        bool $permanent,
        array $headers,
    ): ResponseInterface;
}
