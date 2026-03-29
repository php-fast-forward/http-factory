Installation
============

To install the package via Composer:

.. code-block:: bash

   composer require fast-forward/http-factory

The package will be installed along with its dependencies, including Nyholm PSR-7 and Nyholm ServerRequestCreator.

Integration with fast-forward/container
--------------------------------------

If you use `fast-forward/container`, just add the service provider to your configuration:

.. code-block:: php

   use FastForward\Container\container;
   use FastForward\Config\ArrayConfig;
   use FastForward\Container\ContainerInterface;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;

   $config = new ArrayConfig([
       ContainerInterface::class => [
           HttpMessageFactoryServiceProvider::class,
       ],
   ]);

   $container = container($config);

   $requestFactory = $container->get(Psr\Http\Message\RequestFactoryInterface::class);
   $serverRequest = $container->get(Psr\Http\Message\ServerRequestInterface::class);
