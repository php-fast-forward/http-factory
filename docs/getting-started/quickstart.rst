Quickstart
==========

This example shows the most common beginner workflow:

1. register the provider
2. resolve the convenience factories
3. create common responses without manually building bodies and headers

.. code-block:: php

   use FastForward\Config\ArrayConfig;
   use FastForward\Container\ContainerInterface;
   use FastForward\Container\container;
   use FastForward\Http\Message\Factory\ResponseFactoryInterface;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
   use FastForward\Http\Message\Factory\StreamFactoryInterface;
   use Psr\Http\Message\RequestFactoryInterface;
   use Psr\Http\Message\ServerRequestInterface;

   $config = new ArrayConfig([
       ContainerInterface::class => [
           HttpMessageFactoryServiceProvider::class,
       ],
   ]);

   $container = container($config);

   $requestFactory = $container->get(RequestFactoryInterface::class);
   $serverRequest = $container->get(ServerRequestInterface::class);
   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $streamFactory = $container->get(StreamFactoryInterface::class);

   $request = $requestFactory->createRequest('GET', '/health');

   $jsonResponse = $responseFactory->createResponseFromPayload([
       'ok' => true,
       'path' => (string) $serverRequest->getUri(),
   ]);

   $htmlResponse = $responseFactory->createResponseFromHtml('<h1>Welcome</h1>');

   $redirectResponse = $responseFactory->createResponseRedirect('/login');

   $noContentResponse = $responseFactory->createResponseNoContent([
       'X-Request-Handled' => 'true',
   ]);

   $payloadStream = $streamFactory->createStreamFromPayload([
       'queued' => true,
   ]);

   $acceptedResponse = $responseFactory
       ->createResponse(202)
       ->withHeader('Content-Type', 'application/json; charset=utf-8')
       ->withBody($payloadStream);

What To Notice
--------------

- ``RequestFactoryInterface`` is the standard PSR-17 request factory
- ``ServerRequestInterface`` is created from PHP globals when you resolve it from the container
- ``FastForward\Http\Message\Factory\ResponseFactoryInterface`` adds helper methods on top of PSR-17
- ``FastForward\Http\Message\Factory\StreamFactoryInterface`` adds ``createStreamFromPayload()``

Next Steps
----------

- Read :doc:`../usage/getting-services` to understand which interface to resolve in each situation.
- Read :doc:`../usage/json-response` and :doc:`../usage/stream-usage` if you are building APIs.
