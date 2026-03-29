Getting Services
===============

To use FastForward HTTP Factory, you first need to obtain the desired factories from your PSR-11 container.

Example:
--------

.. code-block:: php

   $requestFactory = $container->get(Psr\Http\Message\RequestFactoryInterface::class);
   $responseFactory = $container->get(Psr\Http\Message\ResponseFactoryInterface::class);
   $streamFactory = $container->get(Psr\Http\Message\StreamFactoryInterface::class);

These factories allow you to create requests, responses, and streams in a fully PSR-compliant way.