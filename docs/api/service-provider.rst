HttpMessageFactoryServiceProvider
=================================

Namespace: ``FastForward\Http\Message\Factory\ServiceProvider``

Purpose
-------

``HttpMessageFactoryServiceProvider`` registers all runtime services exposed by this package.
It is the entry point you typically add to ``fast-forward/container``.

Public API
----------

.. code-block:: php

   final class HttpMessageFactoryServiceProvider implements ServiceProviderInterface
   {
       public function getFactories(): array;

       public function getExtensions(): array;
   }

Registered Services
-------------------

.. list-table::
   :header-rows: 1

   * - Service id
     - Resolved to
   * - ``Psr\Http\Message\RequestFactoryInterface``
     - alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Psr\Http\Message\ResponseFactoryInterface``
     - alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Psr\Http\Message\ServerRequestFactoryInterface``
     - alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Psr\Http\Message\StreamFactoryInterface``
     - alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Psr\Http\Message\UploadedFileFactoryInterface``
     - alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Psr\Http\Message\UriFactoryInterface``
     - alias to ``Nyholm\Psr7\Factory\Psr17Factory``
   * - ``Nyholm\Psr7Server\ServerRequestCreatorInterface``
     - alias to ``Nyholm\Psr7Server\ServerRequestCreator``
   * - ``FastForward\Http\Message\Factory\ResponseFactoryInterface``
     - alias to ``FastForward\Http\Message\Factory\ResponseFactory``
   * - ``FastForward\Http\Message\Factory\StreamFactoryInterface``
     - alias to ``FastForward\Http\Message\Factory\StreamFactory``
   * - ``Nyholm\Psr7\Factory\Psr17Factory``
     - concrete service created with ``InvokableFactory``
   * - ``Nyholm\Psr7Server\ServerRequestCreator``
     - concrete service created with ``InvokableFactory``
   * - ``FastForward\Http\Message\Factory\ResponseFactory``
     - concrete service created with ``InvokableFactory``
   * - ``FastForward\Http\Message\Factory\StreamFactory``
     - concrete service created with ``InvokableFactory``
   * - ``Psr\Http\Message\ServerRequestInterface``
     - created by calling ``ServerRequestCreator::fromGlobals()``

Why ``ServerRequestInterface`` Is Special
-----------------------------------------

Most services in the provider are reusable factories.
``ServerRequestInterface`` is different because it represents the current HTTP request built from PHP globals at resolution time.

That is convenient in regular PHP request lifecycles, but in long-running workers you should resolve it per request and avoid storing it globally.

Extensions
----------

``getExtensions()`` returns an empty array.
This provider only registers factories and aliases; it does not decorate existing services.
