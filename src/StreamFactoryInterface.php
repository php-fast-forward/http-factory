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

namespace FastForward\Http\Message\Factory;

use FastForward\Http\Message\PayloadStreamInterface;
use Psr\Http\Message\StreamFactoryInterface as PsrStreamFactoryInterface;

/**
 * Interface StreamFactoryInterface.
 *
 * Extends the PSR-17 StreamFactoryInterface with additional functionality for creating streams from payloads.
 * Implementations of this interface MUST be capable of generating standard PSR-7 streams as well as payload-aware streams.
 */
interface StreamFactoryInterface extends PsrStreamFactoryInterface
{
    /**
     * Creates a new stream containing the JSON-encoded representation of the provided payload.
     *
     * The returned stream MUST implement PayloadStreamInterface and MUST be readable and seekable.
     * The payload MUST be JSON-encodable and MUST NOT contain resource types.
     *
     * @param array $payload the payload to encode and wrap in the stream
     *
     * @return PayloadStreamInterface the generated stream containing the payload
     */
    public function createStreamFromPayload(array $payload): PayloadStreamInterface;
}
