Getting Services
================

The package exposes more than one factory interface on purpose.
The most common beginner mistake is resolving the PSR interface when they actually wanted the Fast Forward convenience interface, or the other way around.

Which Interface Should You Resolve?
-----------------------------------

.. list-table::
   :header-rows: 1

   * - Resolve this interface
     - When to use it
     - What you get
   * - ``Psr\Http\Message\RequestFactoryInterface``
     - You want standard PSR-17 request creation
     - An alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Psr\Http\Message\ResponseFactoryInterface``
     - You want plain PSR-17 responses only
     - An alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Psr\Http\Message\StreamFactoryInterface``
     - You want plain PSR-17 streams only
     - An alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``FastForward\Http\Message\Factory\ResponseFactoryInterface``
     - You want helper methods for HTML, JSON, text, redirect, and no-content responses
     - An alias to ``FastForward\Http\Message\Factory\ResponseFactory``
   * - ``FastForward\Http\Message\Factory\StreamFactoryInterface``
     - You want helper methods for payload-aware JSON streams
     - An alias to ``FastForward\Http\Message\Factory\StreamFactory``
   * - ``Psr\Http\Message\ServerRequestInterface``
     - You want the current request built from PHP globals
     - The result of ``ServerRequestCreator::fromGlobals()``

Container Example
-----------------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;
   use FastForward\Http\Message\Factory\StreamFactoryInterface;
   use Nyholm\Psr7Server\ServerRequestCreatorInterface;
   use Psr\Http\Message\RequestFactoryInterface;
   use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
   use Psr\Http\Message\ServerRequestInterface;
   use Psr\Http\Message\StreamFactoryInterface as PsrStreamFactoryInterface;

   $requestFactory = $container->get(RequestFactoryInterface::class);
   $psrResponseFactory = $container->get(PsrResponseFactoryInterface::class);
   $psrStreamFactory = $container->get(PsrStreamFactoryInterface::class);

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $streamFactory = $container->get(StreamFactoryInterface::class);

   $serverRequestCreator = $container->get(ServerRequestCreatorInterface::class);
   $serverRequest = $container->get(ServerRequestInterface::class);

Recommended Rule Of Thumb
-------------------------

- Start with the PSR-17 interfaces when you need low-level control
- Reach for the Fast Forward interfaces when the response or stream type is obvious
- Resolve ``ServerRequestInterface`` per HTTP request, not once at application boot in a long-running worker
