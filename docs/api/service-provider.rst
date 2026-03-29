HttpMessageFactoryServiceProvider
=================================

.. code-block:: php

   final class HttpMessageFactoryServiceProvider implements ServiceProviderInterface
   {
       public function getFactories(): array;
       public function getExtensions(): array;
   }

Description
-----------

Registers all PSR-17 and PSR-7 HTTP factories and aliases in a PSR-11 compatible container. Designed for seamless integration with fast-forward/container and other PSR-11 containers.

Methods
-------

- **getFactories(): array**

  Returns the mapping of all registered factories and aliases. This includes all PSR-17 interfaces, Nyholm\Psr7\Factory\Psr17Factory, Nyholm\Psr7Server\ServerRequestCreator, and custom FastForward factories.

- **getExtensions(): array**

  Returns an empty array (no extensions defined by default).

Examples
--------

.. code-block:: php

   $provider = new HttpMessageFactoryServiceProvider();
   $factories = $provider->getFactories();
   // Use with a PSR-11 container
