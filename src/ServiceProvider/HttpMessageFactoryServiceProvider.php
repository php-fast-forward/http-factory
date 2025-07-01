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

namespace FastForward\Http\Message\Factory\ServiceProvider;

use FastForward\Container\Factory\AliasFactory;
use FastForward\Container\Factory\InvokableFactory;
use FastForward\Container\Factory\MethodFactory;
use FastForward\Http\Message\Factory\ResponseFactory;
use FastForward\Http\Message\Factory\ResponseFactoryInterface;
use FastForward\Http\Message\Factory\StreamFactory;
use FastForward\Http\Message\Factory\StreamFactoryInterface;
use Interop\Container\ServiceProviderInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface as PsrStreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * This file is part of php-fast-forward/http-factory.
 *
 * This source file is subject to the license bundled
 * with this source code in the file LICENSE.
 *
 * @see      https://github.com/php-fast-forward/http-factory
 *
 * @copyright Copyright (c) 2025 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */
final class HttpMessageFactoryServiceProvider implements ServiceProviderInterface
{
    /**
     * Returns a list of service factories compliant with PSR-11.
     *
     * This method defines mappings for PSR-17 and PSR-7 related interfaces
     * using Nyholm's implementation. Aliases are created for consistency
     * across PSR interfaces by reusing a single Psr17Factory instance.
     *
     * @return array<string, callable> an associative array of service identifiers to factory definitions
     */
    public function getFactories(): array
    {
        return [
            RequestFactoryInterface::class       => AliasFactory::get(Psr17Factory::class),
            PsrResponseFactoryInterface::class   => AliasFactory::get(Psr17Factory::class),
            ServerRequestFactoryInterface::class => AliasFactory::get(Psr17Factory::class),
            PsrStreamFactoryInterface::class     => AliasFactory::get(Psr17Factory::class),
            UploadedFileFactoryInterface::class  => AliasFactory::get(Psr17Factory::class),
            UriFactoryInterface::class           => AliasFactory::get(Psr17Factory::class),
            ServerRequestCreatorInterface::class => AliasFactory::get(ServerRequestCreator::class),
            ResponseFactoryInterface::class      => AliasFactory::get(ResponseFactory::class),
            StreamFactoryInterface::class        => AliasFactory::get(StreamFactory::class),
            Psr17Factory::class                  => new InvokableFactory(Psr17Factory::class),
            ServerRequestCreator::class          => new InvokableFactory(
                ServerRequestCreator::class,
                RequestFactoryInterface::class,
                UriFactoryInterface::class,
                UploadedFileFactoryInterface::class,
                StreamFactoryInterface::class,
            ),
            ResponseFactory::class => new InvokableFactory(
                ResponseFactory::class,
                PsrResponseFactoryInterface::class,
            ),
            StreamFactory::class => new InvokableFactory(
                StreamFactory::class,
                PsrStreamFactoryInterface::class,
            ),
            ServerRequestInterface::class => new MethodFactory(
                ServerRequestCreator::class,
                'fromGlobals'
            ),
        ];
    }

    /**
     * Returns an array of service extensions.
     *
     * This service provider does not define extensions and SHALL return an empty array.
     *
     * @return array<string, callable> an empty array
     */
    public function getExtensions(): array
    {
        return [];
    }
}
