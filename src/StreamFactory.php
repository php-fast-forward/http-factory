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

use FastForward\Http\Message\JsonStream;
use FastForward\Http\Message\PayloadStreamInterface;
use Psr\Http\Message\StreamFactoryInterface as PsrStreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class StreamFactory.
 *
 * Decorates a PSR-17 StreamFactoryInterface to provide additional functionality for creating payload streams.
 * Implements both standard PSR-17 stream creation methods and convenient payload-aware stream generation.
 *
 * @package FastForward\Http\Message\Factory
 */
final class StreamFactory implements StreamFactoryInterface
{
    /**
     * Constructs the StreamFactory instance.
     *
     * @param PsrStreamFactoryInterface $streamFactory the underlying PSR-17 stream factory implementation
     */
    public function __construct(
        private PsrStreamFactoryInterface $streamFactory,
    ) {}

    /**
     * Creates a new stream containing the provided string content.
     *
     * @param string $content the string content for the stream
     *
     * @return StreamInterface the generated stream
     */
    public function createStream(string $content = ''): StreamInterface
    {
        return $this->streamFactory->createStream($content);
    }

    /**
     * Creates a new stream from the specified file.
     *
     * The file is opened with the given mode, and a stream is returned.
     *
     * @param string $filename the path to the file to open as a stream
     * @param string $mode     The file open mode. Defaults to 'r' (read mode).
     *
     * @return StreamInterface the generated stream
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return $this->streamFactory->createStreamFromFile($filename, $mode);
    }

    /**
     * Creates a new stream from the provided PHP resource.
     *
     * @param resource $resource the PHP resource to wrap as a stream
     *
     * @return StreamInterface the generated stream
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        return $this->streamFactory->createStreamFromResource($resource);
    }

    /**
     * Creates a new stream containing the JSON-encoded representation of the provided payload.
     *
     * The returned stream implements PayloadStreamInterface and contains the encoded payload.
     *
     * @param array $payload the payload to encode as JSON
     *
     * @return PayloadStreamInterface the generated payload stream
     */
    public function createStreamFromPayload(array $payload): PayloadStreamInterface
    {
        return new JsonStream($payload);
    }
}
