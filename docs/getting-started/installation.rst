Installation
============

Requirements
------------

- PHP ``^8.3``
- Composer

Install With Composer
---------------------

.. code-block:: bash

   composer require fast-forward/http-factory

Runtime Dependencies
--------------------

The package installs the pieces it needs to work out of the box:

- ``fast-forward/container`` for the service-provider integration helpers
- ``fast-forward/http-message`` for the specialized response and stream classes returned by the convenience methods
- ``nyholm/psr7-server`` for ``ServerRequestCreator``
- ``psr/http-factory`` for the PSR-17 contracts

Container Registration
----------------------

When you use ``fast-forward/container``, register the service provider once and the package will expose both the PSR-17 services and the Fast Forward convenience factories.

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

Direct Instantiation
--------------------

You can also use the concrete factory classes without a container.
This is useful in small scripts, tests, or when you want the helper methods but not the service-provider layer.

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactory;
   use FastForward\Http\Message\Factory\StreamFactory;
   use Nyholm\Psr7\Factory\Psr17Factory;

   $psr17Factory = new Psr17Factory();

   $responseFactory = new ResponseFactory($psr17Factory);
   $streamFactory = new StreamFactory($psr17Factory);

Continue to :doc:`quickstart` for a minimal end-to-end example.
