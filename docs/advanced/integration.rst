Integration with PSR-11 Containers
==================================

FastForward HTTP Factory is designed to work seamlessly with any PSR-11 compatible container, such as `fast-forward/container` or other popular PHP containers.

Key Points:
-----------

- **Automatic Registration**: All required factories and aliases are registered for immediate use.
- **Configuration Example**:

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

- **Custom Containers**: You can use the service provider with any container that implements PSR-11.
- **Best Practices**: Register the provider as early as possible in your configuration to ensure all HTTP factories are available for dependency injection.
