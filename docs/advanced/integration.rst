Integration
===========

Preferred Integration: ``fast-forward/container``
-------------------------------------------------

The service provider in this package is designed first for ``fast-forward/container``.
That is the most direct way to consume the aliases and factory definitions provided by ``HttpMessageFactoryServiceProvider``.

.. code-block:: php

   use FastForward\Config\ArrayConfig;
   use FastForward\Container\ContainerInterface;
   use FastForward\Container\container;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;

   $config = new ArrayConfig([
       ContainerInterface::class => [
           HttpMessageFactoryServiceProvider::class,
       ],
   ]);

   $container = container($config);

Important Clarification
----------------------

The services exposed by this package are PSR-7 and PSR-17 compatible once resolved, but the service provider itself uses Fast Forward container helper classes such as:

- ``AliasFactory``
- ``InvokableFactory``
- ``MethodFactory``

Because of that, you should not assume that any generic PSR-11 container can consume this provider directly.
If your container does not support Fast Forward service-provider definitions, register equivalent services manually.

Manual Wiring Example
---------------------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactory;
   use FastForward\Http\Message\Factory\StreamFactory;
   use Nyholm\Psr7\Factory\Psr17Factory;
   use Nyholm\Psr7Server\ServerRequestCreator;

   $psr17Factory = new Psr17Factory();

   $responseFactory = new ResponseFactory($psr17Factory);
   $streamFactory = new StreamFactory($psr17Factory);

   $serverRequestCreator = new ServerRequestCreator(
       $psr17Factory,
       $psr17Factory,
       $psr17Factory,
       $streamFactory,
   );

   $serverRequest = $serverRequestCreator->fromGlobals();

Integration Checklist
---------------------

- register the provider once
- inject PSR-17 interfaces where generic factories are enough
- inject Fast Forward interfaces where helper methods improve readability
- resolve ``ServerRequestInterface`` only in the context of an actual HTTP request
